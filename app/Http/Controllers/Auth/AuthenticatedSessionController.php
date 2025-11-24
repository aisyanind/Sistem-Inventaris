<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Http\Controllers\Auth\LoginOtpController; // <-- TAMBAHAN: Import controller OTP

class AuthenticatedSessionController extends Controller
{
    // Menampilkan halaman login
    public function create(): View|RedirectResponse
    {
        return Auth::check() 
            ? redirect()->intended(route('dashboard')) 
            : view('login');
    }

    // Memproses kredensial dan menyiapkan sesi OTP
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate(); 
        
        $user = Auth::user(); 
        session(['pending_login_user_id' => $user->id_user]);

        Auth::logout();
        
        // 1. Panggil metode sendOtp secara internal (Menggunakan POST logic tanpa HTTP GET redirect)
        $otpController = new LoginOtpController();
        // Kami memanggil metode sendOtp dan meneruskan Request yang sama
        // agar ia memiliki akses ke data jika diperlukan oleh logic pengiriman OTP.
        $otpController->sendOtp($request); 

        // 2. Redirect ke halaman form OTP (Ini adalah rute GET)
        return redirect()->route('otp.login.form');
    }

    // Logout dan hapus sesi pengguna
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
