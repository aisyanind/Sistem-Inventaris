<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\RateLimiter;
use App\Models\OtpCode;
use Illuminate\Support\Facades\Log; // Import Log untuk debugging (opsional)

class OtpRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'kode_otp' => ['required', 'string', 'digits:6'],
        ];
    }
    
    public function messages(): array
    {
        return [
            'kode_otp.required' => 'Kode OTP wajib diisi.',
            'kode_otp.digits'   => 'Kode OTP harus terdiri dari 6 digit angka.',
        ];
    }

    public function authenticate(): void
    {
        $pendingUserId = $this->session()->get('pending_login_user_id')
                             ?? $this->session()->get('pending_password_reset_id');

        if (! $pendingUserId) {
            throw ValidationException::withMessages([
                'kode_otp' => 'Sesi verifikasi Anda telah berakhir. Silakan coba kembali dari awal proses login/reset.',
            ]);
        }

        $this->ensureIsNotRateLimited($pendingUserId);
        $otp = OtpCode::where('id_user', $pendingUserId)
            ->where('kode_otp', $this->input('kode_otp'))
            ->first();
            
        if (! $otp) {
            // Kasus 1: OTP tidak ditemukan (salah/sudah dihapus/kode salah).
            RateLimiter::hit($this->throttleKey($pendingUserId));
            throw ValidationException::withMessages(['kode_otp' => 'Kode OTP salah.']);
        }
        
        $message = null;

        if ($otp->sudah_digunakan) {
            $message = 'Kode OTP sudah digunakan. Silakan minta kode baru.';
        } elseif ($otp->berlaku_sampai < now()) {
            $message = 'Kode OTP sudah kadaluarsa. Silakan minta kode baru.';
        }

        if ($message) {
            RateLimiter::hit($this->throttleKey($pendingUserId));
            $this->session()->forget(['pending_login_user_id', 'pending_password_reset_id']);
            throw ValidationException::withMessages(['kode_otp' => $message]);
        }
        
        RateLimiter::clear($this->throttleKey($pendingUserId));
        $otp->update(['sudah_digunakan' => true]);
    }

    public function ensureIsNotRateLimited($userId): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey($userId), 5)) {
            return;
        }

        $seconds = RateLimiter::availableIn($this->throttleKey($userId));
        throw ValidationException::withMessages([
            'kode_otp' => "Terlalu banyak percobaan kode OTP yang salah. Coba lagi dalam {$seconds} detik.",
        ]);
    }

    protected function throttleKey($userId): string
    {
        return 'otp-verify:' . $userId . '|' . $this->ip();
    }
}
