<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsurePasswordResetPending
{
    /**
     * Handle an incoming request.
     *
     * If the authenticated user has a 'password_reset_pending' flag set to true,
     * redirect them to the password reset page.
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            // Jika pengguna sudah login, arahkan ke dashboard
            return redirect()->route('dashboard');
        }
        if (! $request->session()->has('pending_password_reset_id')) {
            return redirect()->route('login')->withErrors(['password_reset' => 'Silakan login terlebih dahulu.']);}
        return $next($request);
    }
}