<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Models\Warranty;
use App\Models\WarrantyInquiries;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class ManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = DB::table('warranties')
            ->selectRaw("
                DATE_FORMAT(created_at, '%Y-%m') as month,
                SUM(status IN ('active', 'pending')) as active,
                SUM(status = 'near-expiry') as near_expiry,
                SUM(status = 'expired') as expired
            ")
            ->where('created_at', '>=', now()->subMonths(11)->startOfMonth())
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->keyBy('month');

        $months = [];
        $active = [];
        $nearExpiry = [];
        $expired = [];

        for ($i = 11; $i >= 0; $i--) {
            $date = now()->startOfMonth()->subMonths($i);
            $key = $date->format('Y-m');

            $months[] = $date->format('M');

            $active[] = $data[$key]->active ?? 0;
            $nearExpiry[] = $data[$key]->near_expiry ?? 0;
            $expired[] = $data[$key]->expired ?? 0;
        }
        // dd($months);

        $products = DB::table('products as p')
            ->join('warranties as w', 'p.id', '=', 'w.product_id')
            ->join('warranty_inquiries as wi', 'w.id', '=', 'wi.warranty_id')
            ->selectRaw('p.name, p.product_image_url, p.category, COUNT(wi.id) as total_inquiries')
            ->groupBy('p.id', 'p.name', 'p.category', 'product_image_url')
            ->orderByDesc('total_inquiries')
            ->limit(5)
            ->get();

        return view('manager.dashboard', [
            'activeWarrantyCount' => Warranty::where('status', '!=', 'expired')->count(),
            'customerCount' => User::where('role', 'customer')->count(),
            'repairInquires' => WarrantyInquiries::where('status', 'open')->count(), // need update status
            'chartMonths' => $months,
            'chartActive' => $active,
            'chartNearExpiry' => $nearExpiry,
            'chartExpired' => $expired,
            'mostReportedProducts' => $products,
            'latestInquiries' => WarrantyInquiries::with('user', 'warranty.product')->latest()->take(5)->get(),
            'pendingInquiries' => WarrantyInquiries::with('user', 'warranty.product')->where('status', 'pending')->orderBy('created_at', 'desc')->take(5)->get()
        ]);
    }

    /**
     * Display a register warranty.
     */
    public function register()
    {
        return view('manager.register', [
            'products' => Product::all()
        ]);
    }

    public function activeWarranties()
    {
        $warranties = Warranty::with('product', 'user')->where('status', '!=', 'expired')->paginate(10);

        return view('manager.active-warranties', [
            'warranties' => $warranties,
        ]);
    }

    public function warrantyInquiries()
    {
        $warrantyInquiries = WarrantyInquiries::with('user', 'warranty.product')->latest()->get();
        return view('manager.warranty-inquiries', [
            'warrantyInquiries' => $warrantyInquiries
        ]);
    }

    public function inquiryResponse(int $id)
    {
        $warranty = Warranty::with('product', 'inquiries', 'inquiries.user', 'inquiries.responses.user')
            ->findOrFail($id);
        // dd($inquiry);

        // collect and combine inquiry and messages
        $inquiry = $warranty->inquiries->first();
        $messages = $this->inquiryMessages(collect([$inquiry]));

        // dd($messages);

        return view('manager.inquiry-response', [
            'inquiry' => $inquiry,
            'messages' => $messages
        ]);
    }

    public function customers()
    {
        $customers = User::where('role', '=', 'customer')->withCount([
            'warranties as active_warranties_count' => function ($query) {
                $query->whereIn('status', ['active', 'near-expiry']);
            },
            'warranties as expired_warranties_count' => function ($query) {
                $query->where('status', 'expired');
            }
        ])->paginate(10);

        return view('manager.customers', [
            'customers' => $customers
        ]);
    }

    public function reports(Request $request)
    {
        $data = $this->reportsData($request);
        return view('manager.reports', $data);
    }

    public function generateReport(Request $request)
    {
        $data = $this->reportsData($request);

        $pdf = Pdf::loadView('manager.warranty-report', $data);
        return $pdf->download("warranty-report-{$data['periodLabel']}.pdf");
    }

    public function staffAccounts()
    {
        return view('manager.staff-accounts', []);
    }

    /**
     * Display a manager profile.
     */
    public function profile()
    {
        return view('manager.profile');
    }

    /**
     * Helper function for pdf and blade reports 
     */
    private function reportsData(Request $request)
    {   
        $allowedPeriod = [7, 12, 30];
        $period = $request->get('period', '12');

        // prevent error when user tries to put a string in query param
        if(!in_array($period, $allowedPeriod)) {
            $period = 12;
        }

        $interval = match ($period) {
            '7' => now()->subDays(6)->startOfDay(),
            '30' => now()->subDays(29)->startOfDay(),
            '12' => now()->subMonths(11)->startOfMonth(),
            default => now()->subMonths(11)->startOfMonth()
        };
        $format = ($period == '12') ? '%Y-%m' : '%Y-%m-%d';

        $rawData = WarrantyInquiries::selectRaw("
            DATE_FORMAT(created_at, '{$format}') as period,
            COUNT(*) as total
        ")
            ->where('created_at', '>=', $interval)
            ->groupBy('period')
            ->pluck('total', 'period');

        $months = collect();

        if ($period == 12) {
            $start = now()->startOfMonth();

            for ($i = 11; $i >= 0; $i--) {
                $date = $start->copy()->subMonths($i);

                $key = $date->format('Y-m');
                $label = $date->format('M');

                $months->push([
                    'month' => $label,
                    'total' => $rawData[$key] ?? 0
                ]);
            }
        } else {
            $start = now();

            for ($i = $period - 1; $i >= 0; $i--) {
                $date = $start->copy()->subDays($i);

                $key = $date->format('Y-m-d');
                $label = $date->format('d M');

                $months->push([
                    'month' => $label,
                    'total' => $rawData[$key] ?? 0
                ]);
            }
        }

        $mostReportedProducts = DB::table('products as p')
            ->leftJoin('warranties as w', 'w.product_id', '=', 'p.id')
            ->leftJoin('warranty_inquiries as wi', function ($join) use ($interval) {
                $join->on('wi.warranty_id', '=', 'w.id')
                    ->where('wi.created_at', '>=', $interval);
            })
            ->select('p.name', DB::raw('COUNT(wi.id) as inquiries_count'))
            ->groupBy('p.name')
            ->orderByDesc('inquiries_count')
            ->take(8)
            ->get();


        // merged charts data and casted into object for calling like a orm in blade
        $datas = (object)[
            'inquiries' => (object)[
                'labels' => $months->pluck('month'),
                'data' => $months->pluck('total'),
            ],
            'reportedProducts' => (object)[
                'labels' => $mostReportedProducts->pluck('name'),
                'data' => $mostReportedProducts->pluck('inquiries_count')
            ]
        ];

        $periodLabel = match ($period) {
            '7'  => 'last-7-days',
            '30' => 'last-30-days',
            '12' => 'last-12-months',
            default => 'last-12-months',
        };

        return [
            'activeWarranty' => Warranty::where('status', '!=', 'expired')->where('expiry_date', '>=', $interval)->count(),
            'warrantyClaimCount' => WarrantyInquiries::where('created_at', '>=', $interval)->count(),
            'resolvedInquiry' => WarrantyInquiries::whereIn('status', ['resolved', 'replaced'])->where('created_at', '>=', $interval)->count(),
            'chartsData' => $datas,
            'nearExpiryWarranties' => Warranty::with('user', 'product')->where('status', 'near-expiry')->orderBy('created_at', 'desc')->get(),
            'selectedPeriod' => $period,
            'periodLabel' => $periodLabel
        ];
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
