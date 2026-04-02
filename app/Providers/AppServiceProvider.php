<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\Warranty;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        /**
         * for the notification for customer this is only accesible if it includes the navigation.blade.php
         * inside the layouts folder in the views, this will only shows activity for 1 week interval
         */
        View::composer('layouts.navigation', function ($view) {
            if (Auth::check()) {
                $userId = Auth::id();
                
                $now = now();
                $oneWeekAgo = now()->subDays(7);
                $oneWeekFromNow = now()->addDays(7);

                $expired = Warranty::with('product')
                    ->where('user_id', $userId)
                    ->where('status', 'expired')
                    ->whereBetween('expiry_date', [$oneWeekAgo, $now])
                    ->get()
                    ->map(fn($w) => (object)[
                        'type' => 'error',
                        'message' => "Your product: {$w->product->name} expired on {$w->expiry_date->format('M d')}",
                        'date' => $w->expiry_date,
                    ]);

                $upcoming = Warranty::with('product')
                    ->where('user_id', $userId)
                    ->where('status', 'near-expiry')
                    ->whereBetween('expiry_date', [$now, $oneWeekFromNow])
                    ->get()
                    ->map(fn($w) => (object)[
                        'type' => 'warning',
                        'message' => "The warranty of your {$w->product->name} expires on, {$w->expiry_date->format('M d')} (within 7 days)",
                        'date' => $w->expiry_date,
                    ]);

                $notifications = $expired->concat($upcoming)
                    ->sortByDesc('date');

                $view->with('notifications', $notifications);
            }
        });
    }
}
