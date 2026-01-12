<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    // --- BAGIAN INI SANGAT PENTING ---
    // Kita kasih tahu Laravel nama tabel aslinya 'peminjaman', bukan 'peminjamen'
    protected $table = 'peminjaman'; 
    // ----------------------------------

    public $timestamps = false;

    protected $fillable = [
    'tanggal_pinjam',
    'nama_peminjam',
    'nip',              // Baru
    'unit_peminjam',
    'arsip_id',
    'jenis_dokumen',    // Baru
    'bukti_peminjaman', // Baru
    'status'
    ];

    public function arsip()
    {
        return $this->belongsTo(Arsip::class, 'arsip_id');
    }
}