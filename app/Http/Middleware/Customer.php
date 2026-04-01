<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Customer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // redirect to login if its a guest
        if(!Auth::check()) {
            return redirect('/login');
        }

        // if its not a customer direct to staff or admin
        if(Auth::user()->role !== 'customer') {
            return redirect('/dashboard');
        }

        return $next($request);
    }
}
