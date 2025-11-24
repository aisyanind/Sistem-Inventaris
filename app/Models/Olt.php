<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Olt extends Model
{
    use HasFactory;

    protected $table = 'olt';
    protected $primaryKey = 'id_olt';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'id_olt',
        'id_model',
        'id_sto',
        'hostname_olt',
        'ip_address',
        'alamat',
        'lokasi',
        'longitude',
        'latitude',
        'foto_olt',
        'foto_rak',
        'foto_topologi',
        'jenis_pembayaran',
        'id_pln',
        'pic_pln',
        'source',
        'vlan',
        'core_idle'
    ];

    // relasi ke model_olt
    public function modelOlt()
    {
        return $this->belongsTo(ModelOlt::class, 'id_model', 'id_model');
    }

    // relasi ke sto
    public function sto()
    {
        return $this->belongsTo(Sto::class, 'id_sto', 'id_sto');
    }

    public function ports()
    {
        return $this->hasMany(PortOlt::class, 'id_olt', 'id_olt');
    }
    public function jumlahPelanggan()
    {
        return $this->hasOne(JumlahPelanggan::class, 'id_olt', 'id_olt');
    }

    public function uplinks()
    {
        return $this->hasManyThrough(Uplink::class, PortOlt::class, 'id_olt', 'id_port_olt', 'id_olt', 'id_port_olt');
    }
}
