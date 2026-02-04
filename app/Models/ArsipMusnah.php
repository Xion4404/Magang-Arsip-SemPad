<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArsipMusnah extends Model
{
    use HasFactory;

    protected $table = 'arsip_musnah';
    protected $guarded = ['id'];
    
    // Include relationships if needed for display (e.g., Klasifikasi)
    public function klasifikasi()
    {
        return $this->belongsTo(\App\Models\MasterKlasifikasi::class, 'klasifikasi_id');
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}
