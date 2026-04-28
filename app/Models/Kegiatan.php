<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tanggal_kegiatan',
        'pic',
        'posisi',
        'judul_kegiatan',
        'kategori_kegiatan',
        'deskripsi',
        'dokumentasi'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
