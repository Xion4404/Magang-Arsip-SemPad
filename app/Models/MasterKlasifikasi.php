<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterKlasifikasi extends Model
{
    use HasFactory;

    protected $table = 'master_klasifikasi';
    public $timestamps = false;

    protected $fillable = [
        'kode_klasifikasi', 
        'jenis_arsip', 
        'masa_simpan', 
        'tindakan_akhir'
    ];

    // Relasi: Satu klasifikasi bisa punya banyak arsip
    public function arsip()
    {
        return $this->hasMany(Arsip::class, 'klasifikasi_id');
    }
}