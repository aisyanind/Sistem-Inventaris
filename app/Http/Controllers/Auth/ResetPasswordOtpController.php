<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\OtpCode;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\OtpRequest;
use App\Http\Requests\Auth\SendResetOtpRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Helpers\TelegramHelper;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Illuminate\Support\Facades\RateLimiter;

class ResetPasswordOtpController extends Controller
{
    public function showRequestForm(): View
    {
        return view('auth.forgot-password');
    }

    public function sendOtp(SendResetOtpRequest $request): RedirectResponse
    {
        $user = User::where('id_telegram', $request->id_telegram)->firstOrFail();
        $this->generateAndSendOtp($user);
        
        $request->hitRateLimiter(); 

        session(['pending_password_reset_id' => $user->id_user]);

        return redirect()->route('otp.reset.form');
    }

    public function showOtpForm(): View|RedirectResponse
    {
        if (! session()->has('pending_password_reset_id')) {
            return redirect()->route('password.request')->with('error', 'Silakan minta OTP terlebih dahulu.');
        }
        return view('auth.otp-reset');
    }

    public function verifyOtp(OtpRequest $request): RedirectResponse
    {
        $request->authenticate(); 

        $pendingUserId = session('pending_password_reset_id');
        
        $sendOtpThrottleKey = 'send-reset-otp:' . $request->id_telegram;
        RateLimiter::clear($sendOtpThrottleKey);

        session(['otp_verified' => true]);

        return redirect()->route('password.reset.form');
    }

    public function showResetForm(Request $request): View|RedirectResponse
    {
        if (! $request->session()->get('otp_verified')) {
            return redirect()->route('password.request')->withErrors(['otp' => 'Silakan verifikasi OTP terlebih dahulu.']);
        }
        return view('auth.reset-password');
    }

    public function resetPassword(ResetPasswordRequest $request): RedirectResponse
    {
        if (! $request->session()->get('otp_verified')) {
            return redirect()->route('password.request')->withErrors(['otp' => 'Verifikasi OTP gagal. Silakan mulai kembali.']);
        }
        
        $userId = session('pending_password_reset_id');
        $user = User::findOrFail($userId);

        $user->update(['password' => Hash::make($request->password)]);

        $request->session()->forget(['pending_password_reset_id', 'otp_verified']);
        $request->session()->regenerate();

        return redirect()->route('login')->with('status', 'Password berhasil diubah. Silakan login.');
    }
    
    protected function generateAndSendOtp(User $user): void
    {
        $otp = OtpCode::generateForUser($user->id_user);

        $message = "Halo {$user->username},\n\n"
                  . "Kode OTP untuk mereset password kamu: {$otp->kode_otp}\n"
                  . "Berlaku selama 1 menit.\n\n"
                  . "Abaikan pesan ini jika Anda tidak merasa meminta reset password.";

        TelegramHelper::sendMessage($user->id_telegram, $message);
    }
}
