<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MediaInformasi extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    protected $table = 'media_informasi';

    protected $fillable = [
        'judul',
        'tanggal',
        'deskripsi',
        'gambar',
    ];
<<<<<<< HEAD
}
=======
}
>>>>>>> 7d4f385849d706498d1a4faaf8f83b504a2a87f9
