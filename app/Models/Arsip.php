<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Arsip extends Model
{
    use HasFactory;

    protected $table = 'arsip';
    protected $guarded = ['id'];
    public $timestamps = false;

    public function klasifikasi()
    {
        return $this->belongsTo(MasterKlasifikasi::class, 'klasifikasi_id');
    }
}