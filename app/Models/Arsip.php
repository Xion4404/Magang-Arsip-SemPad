<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Arsip extends Model
{
    use HasFactory;

    // Nama tabel di database kamu (sesuai file sql 'ears')
    protected $table = 'arsip'; 
    
    // Tidak pakai created_at & updated_at (sesuai struktur tabel kamu)
    public $timestamps = false; 

    protected $fillable = [
        'arsip_masuk_id',
        'no_berkas', 
        'klasifikasi_id', 
        'nama_berkas', 
        'isi_berkas', 
        'jenis_media',
        'tahun', 
        'tanggal_masuk', 
        'jumlah', 
        'no_box', 
        'user_id',
        
        // --- TAMBAHAN BARU (FITUR KEAMANAN) ---
        // Biar bisa simpan status Rahasia/Terbatas/Biasa
        'klasifikasi_keamanan', 
        // Biar tahu arsip ini milik Unit mana (untuk cek hak akses)
        'unit_pengolah'         
    ];

    public function klasifikasi()
    {
        return $this->belongsTo(MasterKlasifikasi::class, 'klasifikasi_id');
    }

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'arsip_id');
    }
}