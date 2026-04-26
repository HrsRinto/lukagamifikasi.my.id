<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materi extends Model
{
    use HasFactory;

    protected $table = 'materis';

    // Mengizinkan semua data masuk (aman selama divalidasi di controller)
    protected $guarded = [];

    // Relasi ke Soal
    public function soals()
    {
        return $this->hasMany(Soal::class);
    }

    /**
     * AKSESOR PINTAR: youtube_id
     * * Fungsi ini akan otomatis dipanggil saat Anda menulis {{ $materi->youtube_id }}
     * Logika ini menggunakan Regex yang sama dengan yang ada di View, jadi pasti akurat.
     */
    public function getYoutubeIdAttribute()
    {
        // 1. Ambil link asli dari database
        // Pastikan nama kolom di database Anda 'video_url' (sesuai file show.blade.php Anda)
        // Jika nama kolomnya 'link_video' atau 'url', ganti teks 'video_url' di bawah ini.
        $url = $this->video_url ?? $this->link_video ?? $this->url ?? '';

        // 2. Pola Regex (Paling Ampuh untuk YouTube)
        $pattern = '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i';

        // 3. Cek Cocoklogi
        if (preg_match($pattern, $url, $match)) {
            return $match[1]; // Mengembalikan ID Murni (contoh: dQw4w9WgXcQ)
        }

        // 4. Fallback: Jika gagal, kembalikan null agar tidak error parah
        return null;
    }
}
