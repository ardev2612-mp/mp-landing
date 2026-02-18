<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CustomerAuth
{
    /**
     * Handle an incoming request.
     * Ensures the customer is authenticated via the 'customer' guard.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::guard('customer')->check()) {
            return redirect()->route('customer.login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        return $next($request);
    }
}
