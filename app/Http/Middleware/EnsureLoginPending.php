<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureLoginPending
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            // Jika pengguna sudah login, arahkan ke dashboard
            return redirect()->route('dashboard');
        }
        if (! $request->session()->has('pending_login_user_id')) {
            return redirect()->route('login')->withErrors(['otp' => 'Silakan login dengan username & password terlebih dahulu.']);
        }
        return $next($request);
    }
}
