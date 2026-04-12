<?php

namespace App\Http\Controllers;

use App\Enum\InquiryStatusType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Warranty;
use App\Models\WarrantyInquiries;
use Illuminate\Support\Str;
use App\Enum\WarrantyStatusType;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = Auth::user()->id;
        $activeWarranties = Warranty::whereUserId($userId)
            ->where('status', '!=', WarrantyStatusType::EXPIRED->value)
            ->count();

        $expWarCount = Warranty::whereUserId($userId)
            ->where('status', WarrantyStatusType::NEAR_EXPIRY->value)
            ->count();

        $recentlyPurchased = Warranty::whereUserId($userId)
            ->with('product')
            ->latest('purchase_date')
            ->take(3)
            ->get();

        $resolvedInquiryCount = WarrantyInquiries::whereUserId($userId)
            ->where('status', InquiryStatusType::RESOLVED)
            ->count();

        $expiringWarranties = Warranty::whereUserId($userId)
            ->with('product')
            ->whereIn('status', [WarrantyStatusType::EXPIRED->value, WarrantyStatusType::NEAR_EXPIRY->value])
            ->latest('expiry_date')
            ->limit(3)
            ->get();

        return view('customer.dashboard', [
            'activeWarranties' => $activeWarranties,
            'expWarCount' => $expWarCount,
            'recentlyPurchased' => $recentlyPurchased,
            'expiringWarranties' => $expiringWarranties,
            'resolvedInquiryCount' => $resolvedInquiryCount
        ]);
    }

    /**
     * Display list of warranties
     */
    public function list(Request $request)
    {
        $warranties = Warranty::with('product')
            ->whereUserId(Auth::user()->id)
            ->when($request->search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('serial_number', 'like', "%{$search}%")
                        ->orWhereHas('product', function ($q2) use ($search) {
                            $q2->where('name', 'like', "%{$search}%");
                        });
                });
            })->when($request->status, function ($query, $status) {
                if ($status === 'active') $query->whereDate('expiry_date', '>', now()->addDays(30));
                if ($status === 'near_expiry') $query->whereBetween('expiry_date', [now(), now()->addDays(30)]);
                if ($status === 'expired') $query->whereDate('expiry_date', '<', now());
            })
            ->paginate(10);

        return view('customer.warranty', [
            'warranties' => $warranties
        ]);
    }

    /**
     * Display list of history
     */
    public function history()
    {
        $userId = Auth::user()->id;

        // registered warranty history map it with the type, date, title, and description
        $registeredWarranty = Warranty::with('product')
            ->whereUserId($userId)
            ->get()
            ->map(fn($registered) => (object)[
                'type' => 'success',
                'date' => $registered->created_at,
                'title' => "Registered {$registered->product->name}",
                'description' => "Serial: {$registered->serial_number}",
                'url' => route('warranty.show', $registered->id)
            ]);

        $inquiries = WarrantyInquiries::with('warranty.product')
            ->whereUserId($userId)
            ->get()
            ->map(fn($inquiry) => (object)[
                'type' => 'new',
                'date' => $inquiry->created_at,
                'title' => "Opened an inquiry for {$inquiry->warranty->product->name}",
                'description' => Str::limit($inquiry->message, 60),
                'url' => route('inquiry.show', $inquiry->id)
            ]);

        $statusUpdates = WarrantyInquiries::with('warranty.product')
            ->whereUserId($userId)
            ->whereIn('status', ['resolved', 'replaced', 'closed'])
            ->get()
            ->map(function ($update) {

                $type = match ($update->status->value) {
                    'resolved' => 'success',
                    'replaced' => 'success',
                    'closed' => 'default',
                };

                return (object)[
                    'type' => $type,
                    'date' => $update->updated_at,
                    'title' => "Inquiry {$update->status->value}",
                    'description' => "Your inquiry for {$update->warranty->product->name} was {$update->status->value}.",
                    'url' => route('inquiry.show', $update->id)
                ];
            });

        $expiredWarranty = Warranty::with('product')
            ->whereUserId($userId)
            ->whereDate('expiry_date', '<=', now())
            ->get()
            ->map(fn($w) => (object)[
                'type' => 'expire',
                'date' => $w->expiry_date,
                'title' => "{$w->product->name} warranty expired",
                'description' => "Expired on " . $w->expiry_date->format('M d, Y'),
                'url' => route('warranty.show', $w->id)
            ]);

        // refactor with paginator
        // merge the queries to loop it in the blade foreach
        $history = collect()
            ->concat($registeredWarranty)
            ->concat($inquiries)
            ->concat($statusUpdates)
            ->concat($expiredWarranty)
            ->sortByDesc('date');

        return view('customer.history', [
            'history' => $history
        ]);
    }
    /**
     * Display list of replacement
     */
    public function inquiries(Request $request)
    {
        $inquiries = WarrantyInquiries::with(['warranty.product', 'warranty'])
            ->whereUserId(Auth::user()->id)
            ->when($request->search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->whereHas('warranty', function($q1) use($search) {
                        $q1->where('serial_number', 'like', "%{$search}%");
                    })
                    ->orWhereHas('warranty.product', function ($q2) use ($search) {
                        $q2->where('name', 'like', "%{$search}%");
                    });
                });
            })
            ->when($request->status, function($query, $status) {
                $query->where('status', $status);
            })
            ->latest('updated_at')
            ->paginate(10);

        return view('customer.inquiries', [
            'inquiries' => $inquiries
        ]);
    }

    public function showInquiry(string $id)
    {
        $inquiry = WarrantyInquiries::with(['warranty.product', 'warranty.user'])
            ->whereUserId(Auth::user()->id)
            ->where('id', $id)
            ->firstOrFail();

        // dd($inquiry);

        return view('customer.show-inquiry', [
            'inquiry' => $inquiry
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $userId = Auth::id();

        // get the warranty info for the id
        $warranty = Warranty::with(['product', 'inquiries', 'inquiries.user', 'inquiries.responses.user'])
            ->whereUserId($userId)
            ->where('id', $id)
            ->firstOrFail();

        $latestInquiry = $warranty->inquiries->last();
        // dd($warranty);

        // check if this warranty does not have a inquiries for the ux
        $containsInquiries = $warranty->inquiries->isNotEmpty();

        $history = WarrantyInquiries::with('user')->where('warranty_id', $warranty->id)->get();
        // use the temporary helper for message
        $messages = $this->inquiryMessages($warranty->inquiries);
        // dd($messages);

        return view('customer.show', [
            'warranty' => $warranty,
            'history' => $history,
            'id' => $latestInquiry?->id,
            'messages' => $messages,
            'containsInquiries' => $containsInquiries
        ]);
    }
}
