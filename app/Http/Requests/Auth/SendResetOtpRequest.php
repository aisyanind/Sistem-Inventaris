<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;

class SendResetOtpRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_telegram' => ['required', 'string', 'exists:users,id_telegram'],
        ];
    }

    public function messages(): array
    {
        return [
            'id_telegram.required' => 'ID Telegram wajib diisi.',
            'id_telegram.exists'   => 'ID Telegram tidak terdaftar.',
        ];
    }

    // Pengecekan rate limit akan berjalan otomatis di sini.
    public function withValidator(Validator $validator): void
    {
        $validator->after(function ($validator) {
            if (RateLimiter::tooManyAttempts($this->throttleKey(), 3)) { // 3 percobaan
                $seconds = RateLimiter::availableIn($this->throttleKey());
                throw ValidationException::withMessages([
                    'id_telegram' => "Terlalu banyak permintaan OTP. Coba lagi dalam {$seconds} detik.",
                ]);
            }
        });
    }
    
    // Method ini dipanggil dari Controller SETELAH OTP berhasil dikirim.
    public function hitRateLimiter(): void
    {
        RateLimiter::hit($this->throttleKey(), 60); // Kunci selama 60 detik
    }

    // Membuat kunci unik untuk rate limiter berdasarkan alamat IP.
    protected function throttleKey(): string
    {
        return 'reset-password-otp:' . $this->ip();
    }
}