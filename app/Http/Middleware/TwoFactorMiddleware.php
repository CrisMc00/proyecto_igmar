<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TwoFactorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->google2fa_secret) {
            if (!session()->has('otp_verified') && !$request->is('verify-otp*') && !$request->is('setup-2fa*')) {
                return redirect()->route('otp.verify');
            }
        }
        return $next($request);
    }
}
