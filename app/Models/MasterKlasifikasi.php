<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterKlasifikasi extends Model
{
    use HasFactory;

    protected $table = 'master_klasifikasi';
    
    // Assuming structure based on typical master tables, modifying later if needed
    // Usually has id, code, name/description
    protected $guarded = ['id']; 
}