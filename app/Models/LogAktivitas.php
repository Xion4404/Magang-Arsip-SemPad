<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogAktivitas extends Model
{
    protected $table = 'log_aktivitas';

    protected $fillable = [
        'user_id',
        'tahapan',
        'tanggal_berkas_masuk',
        'unit_kerja',
        'nba',
        'jumlah_box',
        'keterangan',
        'status_kerja',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
