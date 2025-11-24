<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder; // Import Builder for scope type hint

class OtpCode extends Model
{
    use HasFactory;

    public const OTP_EXPIRATION_MINUTES = 1;

    protected $table = 'otp';
    protected $primaryKey = 'id_user';
    protected $keyType = 'int';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id_user',
        'kode_otp',
        'sudah_digunakan',
        'berlaku_sampai',
    ];

    protected $casts = [
        'berlaku_sampai' => 'datetime',
        'sudah_digunakan' => 'boolean'
    ];

    
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public static function generateForUser(int $idUser): self
    {
        $otpCode = rand(100000, 999999);

        $otp = self::updateOrCreate(
            ['id_user' => $idUser],
            [
                'kode_otp' => $otpCode,
                'berlaku_sampai' => now()->addMinutes(self::OTP_EXPIRATION_MINUTES),
                'sudah_digunakan' => false,
            ]
        );


        return $otp;
    }

   
    public function scopeValid(Builder $query, int $idUser, string|int $otpCode): Builder
    {
        return $query->where('id_user', $idUser)
                     ->where('kode_otp', $otpCode)
                     ->where('sudah_digunakan', false)
                     ->where('berlaku_sampai', '>', now());
    }

    public function isExpired(): bool
    {
        // Karena 'berlaku_sampai' dicast ke 'datetime', kita bisa menggunakan method isPast() dari Carbon.
        return $this->berlaku_sampai->isPast();
    }

    public function markAsUsed(): bool
    {
        $this->sudah_digunakan = true;
        return $this->save();
    }
}
