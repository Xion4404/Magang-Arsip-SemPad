<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPeminjaman extends Model
{
    use HasFactory;

    protected $table = 'detail_peminjaman';
    protected $guarded = ['id']; // Izinkan semua kolom diisi

    // Relasi balik ke Peminjaman Utama
    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class, 'peminjaman_id');
    }

    // Relasi ke Master Arsip (Kalau pilih dari database)
    public function arsip()
    {
        return $this->belongsTo(Arsip::class, 'arsip_id');
    }
    
    // Helper untuk ambil Nama Arsip (baik dari DB atau Manual)
    public function getNamaBerkasAttribute()
    {
        return $this->arsip ? $this->arsip->nama_berkas : $this->nama_arsip;
    }
}