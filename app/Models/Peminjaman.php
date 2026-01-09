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
        'arsip_id',
        'nama_peminjam',
        'unit_peminjam',
        'tanggal_pinjam',
        'status',
    ];

    public function arsip()
    {
        return $this->belongsTo(Arsip::class, 'arsip_id');
    }
}