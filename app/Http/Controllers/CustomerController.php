<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Warranty;
use App\Models\InquiryResponse;
use App\Models\WarrantyInquiries;
use App\Models\WarrantyResponse;

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
        return view('customer.history');
    }

    /**
     * Display list of replacement
     */
    public function replacement()
    {
        return view('customer.replacements');
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
