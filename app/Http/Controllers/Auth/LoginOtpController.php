<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\OtpCode;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Http\Requests\Auth\OtpRequest;
use App\Helpers\TelegramHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;

class LoginOtpController extends Controller
{
    public function showOtpForm(Request $request): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        if (! $request->session()->has('pending_login_user_id')) {
            return redirect()->route('login')->with('error', 'Silakan masukkan kredensial Anda terlebih dahulu.');
        }
        return view('auth.otp');
    }

    public function sendOtp(Request $request): RedirectResponse
    {
        $pendingUserId = $request->session()->get('pending_login_user_id');
        if (!$pendingUserId) {
             return redirect()->route('login')->with('error', 'Sesi Anda telah berakhir. Silakan coba kembali.');
        }
        
        $throttleKey = 'send-otp:' . $pendingUserId;

        if (RateLimiter::tooManyAttempts($throttleKey, 1)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return back()->with('error', "Anda baru bisa meminta OTP baru dalam {$seconds} detik.");
        }

        $user = User::findOrFail($pendingUserId);
        $otp = OtpCode::generateForUser($user->id_user);

        $message = "Halo {$user->username},\n\n"
                  . "Kode OTP kamu: {$otp->kode_otp}\n" 
                  . "Berlaku selama 1 menit.\n\n"
                  . "Jika bukan kamu yang melakukan login, abaikan pesan ini.";

        TelegramHelper::sendMessage($user->id_telegram, $message);
        RateLimiter::hit($throttleKey, 60);

        return redirect()->route('otp.login.form')->with('success', 'Kode OTP baru telah dikirim.');
    }

    public function verifyOtp(OtpRequest $request): RedirectResponse
    {
        $request->authenticate();

        $pendingUserId = $request->session()->get('pending_login_user_id');
        
        $sendOtpThrottleKey = 'send-otp:' . $pendingUserId;
        RateLimiter::clear($sendOtpThrottleKey); 

        Auth::loginUsingId($pendingUserId);

        $request->session()->forget('pending_login_user_id');
        $request->session()->regenerate();

        return redirect()->route('dashboard');
    }
}
