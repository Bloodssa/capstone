<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Warranty;
use App\Models\WarrantyInquiries;
use Illuminate\Support\Str;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $activeWarranties = Warranty::whereUserId(Auth::user()->id)
            ->where('status', '!=', 'expired')
            ->count();

        $expWarCount = Warranty::whereUserId(Auth::user()->id)
            ->where('status', 'near-expiry')
            ->count();

        $recentlyPurchased = Warranty::whereUserId(Auth::user()->id)
            ->with('product')
            ->latest('purchase_date')
            ->take(3)
            ->get();

        $expiringWarranties = $expiringWarranties = Warranty::whereUserId(Auth::user()->id)
            ->with('product')
            ->whereIn('status', ['expired', 'near-expiry'])
            ->latest('expiry_date')
            ->limit(3)
            ->get();

        return view('customer.dashboard', [
            'activeWarranties' => $activeWarranties,
            'expWarCount' => $expWarCount,
            'recentlyPurchased' => $recentlyPurchased,
            'expiringWarranties' => $expiringWarranties
        ]);
    }

    /**
     * Display list of warranties
     */
    public function list()
    {
        $warranties = Warranty::with('product')
            ->where('user_id', Auth::user()->id)
            ->get();

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
            ->where('user_id', $userId)
            ->get()
            ->map(fn($registered) => (object)[
                'type' => 'success',
                'date' => $registered->created_at,
                'title' => "Registered {$registered->product->name}",
                'description' => "Serial: {$registered->serial_number}"
            ]);

        $inquiries = WarrantyInquiries::with('warranty.product')
            ->where('user_id', $userId)
            ->get()
            ->map(fn($inquiry) => (object)[
                'type' => 'new',
                'date' => $inquiry->created_at,
                'title' => "Opened an inquiry for {$inquiry->warranty->product->name}",
                'description' => Str::limit($inquiry->message, 60),
            ]);

        $statusUpdates = WarrantyInquiries::with('warranty.product')
            ->where('user_id', $userId)
            ->whereIn('status', ['resolved', 'replaced', 'closed'])
            ->get()
            ->map(function ($update) {

                $type = match ($update->status) {
                    'resolved' => 'success',
                    'replaced' => 'success',
                    'closed' => 'default',
                };

                return (object)[
                    'type' => $type,
                    'date' => $update->updated_at,
                    'title' => "Inquiry {$update->status}",
                    'description' => "Your inquiry for {$update->warranty->product->name} was {$update->status}.",
                ];
            });

        $expiredWarranty = Warranty::with('product')
            ->where('user_id', $userId)
            ->whereDate('expiry_date', '<=', now())
            ->get()
            ->map(fn($w) => (object)[
                'type' => 'expire',
                'date' => $w->expiry_date,
                'title' => "{$w->product->name} warranty expired",
                'description' => "Expired on " . $w->expiry_date->format('M d, Y'),
            ]);

        // refactor with paginator
        // merge the queries to loop it in the blade foreach
        $history = collect()
            ->concat($registeredWarranty)
            ->concat($inquiries)
            ->concat($statusUpdates)
            ->concat($expiredWarranty)
            ->sortBy('date');

        return view('customer.history', [
            'history' => $history
        ]);
    }
    /**
     * Display list of replacement
     */
    public function inquiries()
    {
        return view('customer.inquiries');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // get the warranty info for the id
        $warranty = Warranty::with('product', 'inquiries.user', 'inquiries.responses.user')
            ->findOrFail($id);

        // dd($warranty);

        return view('customer.show', [
            'warranty' => $warranty
        ]);
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
