<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BerkasArsipMasuk extends Model
{
    use HasFactory;

    protected $table = 'berkas_arsip_masuk';

    protected $fillable = [
        'arsip_masuk_id',
        'no_box',
        'klasifikasi_id',
        'nama_berkas',
        'isi_berkas',
        'tanggal_berkas',
        'jumlah',
    ];

    public function arsipMasuk()
    {
        return $this->belongsTo(ArsipMasuk::class);
    }

    public function klasifikasi() // Assuming MasterKlasifikasi model exists or will be needed
    {
        return $this->belongsTo(MasterKlasifikasi::class, 'klasifikasi_id');
    }
}
