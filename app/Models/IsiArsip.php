<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IsiArsip extends Model
{
    use HasFactory;

    protected $table = 'isi_arsip';
    protected $guarded = ['id'];
    
    protected $fillable = [
        'arsip_id',
        'isi',
        'tahun',
        'tanggal',
        'jumlah',
        'hak_akses',
        'no_box',
        'jenis_media',
        'masa_simpan',
        'tindakan_akhir'
    ];

    public function arsip()
    {
        return $this->belongsTo(Arsip::class);
    }
}