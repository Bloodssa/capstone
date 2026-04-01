<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Warranty;

abstract class Controller
{
    /**
     * Helper for the claim of customer and set the warranty invitation token to null means its already claimed
     */
    protected function claimWarranty(User $user)
    {
        // check if there is a set claim_email in the session if not set to current google login email
        $warrantyId = session('claim_warranty');

        if (!$warrantyId) {
            return;
        }

        $warrantyClaim = Warranty::where('id', $warrantyId)->where('is_claimed', false)->first();

        if ($warrantyClaim) {
            // set null for one claim only
            $warrantyClaim->update([
                'user_id' => $user->id,
                'is_claimed' => true,
                'status' => 'active'
            ]);
        }

        // remove the claim_email session set in the showRegister
        session()->forget('claim_warranty');
    }
}
