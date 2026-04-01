<?php

namespace App\Console\Commands;

use App\Mail\WarrantyNearExpiry;
use App\Models\Warranty;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\WarrantyExpired;

class WarrantyStatusNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'warranty:status-notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update warranty status to active, near expiry, expired';

    /**
     * Execute the console command.
     * 
     * Updates the status of the warranty and send warrantyStatus mail to the customer
     */
    public function handle()
    {
        $today = now()->today();
        $thirtyDaysFromNow = now()->addMonth()->endOfDay();

        // update expiration date to expired
        $expiredWarranties = Warranty::whereDate('expiry_date', '<=', $today)
            ->where('status', '!=', 'expired')
            ->get();

        foreach ($expiredWarranties as $expireWarranty) {
            $expireWarranty->update(['status' => 'expired']);

            Mail::to($expireWarranty->user->email)->send(new WarrantyExpired($expireWarranty));
        }

        // update near expiry
        $nearExpiry = Warranty::whereDate('expiry_date', '>=', $today)
            ->whereDate('expiry_date', '<=', $thirtyDaysFromNow)
            ->where('status', '!=', 'near-expiry')
            ->where('status', '!=', 'expired')
            ->whereNotNull('user_id')
            ->get();

        foreach ($nearExpiry as $nearExpire) {
            $nearExpire->update(['status' => 'near-expiry']);

            Mail::to($nearExpire->user->email)->send(new WarrantyNearExpiry($nearExpire));
        }

        // incase of error mark the updated error if its 30 days up
        Warranty::whereDate('expiry_date', '>', $thirtyDaysFromNow)
            ->where('status', 'pending')
            ->whereNotNull('user_id')
            ->update(['status' => 'active']);
    }
}
