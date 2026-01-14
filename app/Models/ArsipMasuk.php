<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArsipMasuk extends Model
{
    use HasFactory;

    protected $table = 'arsip_masuk';
    // public $timestamps = false; // Timestamps are true by default

    protected $fillable = [
        'unit_asal',
        'nomor_berita_acara',
        'tanggal_terima',
        'jumlah_box_masuk',
        'user_penerima',
    ];

    public function berkas()
    {
        return $this->hasMany(BerkasArsipMasuk::class);
    }

    public function logAktivitas()
    {
        return $this->hasMany(LogAktivitas::class);
    }

    public function penerima()
    {
        return $this->belongsTo(User::class, 'user_penerima');
    }
}
