<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjaman'; 
    public $timestamps = true; // Ubah true biar created_at otomatis

    protected $fillable = [
        'tanggal_pinjam',
        'nama_peminjam',
        'nip',
        'unit_peminjam',
        'jabatan_peminjam',
        'keperluan',
        'bukti_peminjaman',
        'status',
        'is_approved_khusus'
        // 'arsip_id' dan 'jenis_dokumen' DIHAPUS karena pindah ke tabel detail
    ];

    // Relasi: 1 Peminjaman punya BANYAK Detail
    public function details()
    {
        return $this->hasMany(DetailPeminjaman::class, 'peminjaman_id');
    }

    // --- HELPER AGAR CODINGAN LAMA DI INDEX GAK ERROR ---
    // Saat dipanggil $item->arsip, kita kasih arsip pertama dari detail
    public function getArsipAttribute()
    {
        return $this->details->first()?->arsip; 
    }
    
    // Helper untuk nama manual
    public function getNamaArsipManualAttribute()
    {
        return $this->details->first()?->nama_arsip;
    }
    
    // Helper untuk jenis dokumen (digabung)
    public function getJenisDokumenAttribute()
    {
        $detail = $this->details->first();
        if (!$detail) return '-';
        return $detail->jenis_arsip . ($detail->detail_fisik ? ' - ' . $detail->detail_fisik : '');
    }
}