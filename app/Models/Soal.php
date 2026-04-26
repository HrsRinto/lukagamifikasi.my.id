<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Soal extends Model
{
    use HasFactory;

    protected $table = 'soals';

    // PENTING: Ini membuka kunci agar semua kolom bisa diisi
    protected $guarded = []; 

    // Relasi ke Materi
    public function materi()
    {
        return $this->belongsTo(Materi::class);
    }
}