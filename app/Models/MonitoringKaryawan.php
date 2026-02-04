<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MonitoringKaryawan extends Model
{
    protected $table = 'monitoring_karyawan';

    protected $fillable = [
        'user_id',
        'tahapan',
        'tanggal_kerja',
        'nba',
        'unit_kerja',
        'jumlah_box_selesai',
        'keterangan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
