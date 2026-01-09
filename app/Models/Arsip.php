<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Arsip extends Model
{
    use HasFactory;

    protected $table = 'arsip';
    public $timestamps = false;

    protected $fillable = [
        'no_berkas', 
        'klasifikasi_id', 
        'nama_berkas', 
        'isi_berkas', 
        'tahun', 
        'tanggal_masuk', 
        'jumlah', 
        'no_box', 
        'user_id'
    ];

    // Relasi ke Klasifikasi (Opsional, buat jaga-jaga)
    public function klasifikasi()
    {
        return $this->belongsTo(MasterKlasifikasi::class, 'klasifikasi_id');
    }

    // Relasi ke Peminjaman (Satu arsip bisa dipinjam berkali-kali)
    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'arsip_id');
    }
}