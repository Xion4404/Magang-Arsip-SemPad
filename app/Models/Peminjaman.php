<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    // --- PENGATURAN TABEL (DIPERTAHANKAN) ---
    protected $table = 'peminjaman'; 
    public $timestamps = false;
    // ----------------------------------------

    protected $fillable = [
        'tanggal_pinjam',
        'nama_peminjam',
        'nip',
        'unit_peminjam',
        'arsip_id',
        'jenis_dokumen',
        'bukti_peminjaman',
        'status',
        
        // --- TAMBAHAN BARU (FITUR KEAMANAN) ---
        'jabatan_peminjam',   // Menyimpan data: Direksi, Band I, Pelaksana, dll
        'is_approved_khusus'  // Menyimpan status: Apakah pakai surat kuasa? (0/1)
    ];

    public function arsip()
    {
        return $this->belongsTo(Arsip::class, 'arsip_id');
    }
}