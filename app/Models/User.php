<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'points',
        'level',
        'profile_photo_path',
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // ==========================================
    // RELASI DATABASE
    // ==========================================
    
    // Relasi: User ke Materi (Many-to-Many via tabel pivot materi_user)
    public function materis()
    {
        return $this->belongsToMany(Materi::class, 'materi_user')
                    ->withPivot(['is_watched', 'quiz_score'])
                    ->withTimestamps();
    }

    // ==========================================
    // ACCESSORS (LOGIKA TAMPILAN)
    // ==========================================

    // 1. Menentukan Nama Batch (Pangkat) berdasarkan Poin 0-60
    public function getBatchAttribute()
    {
        $p = $this->points;

        // Logika Baru: 0-60 Point
        if ($p >= 49) return 'Master';
        if ($p >= 37) return 'Platinum';
        if ($p >= 25) return 'Gold';
        if ($p >= 13) return 'Silver';
        return 'Bronze'; 
    }

    // 2. Menentukan Warna Pangkat (Tailwind CSS)
    public function getBatchColorAttribute()
    {
        $batch = $this->batch; // Mengambil hasil dari fungsi getBatchAttribute di atas

        switch ($batch) {
            case 'Master':   return 'bg-purple-100 text-purple-800 border-purple-300';
            case 'Platinum': return 'bg-cyan-100 text-cyan-800 border-cyan-300';
            case 'Gold':     return 'bg-yellow-100 text-yellow-800 border-yellow-300';
            case 'Silver':   return 'bg-gray-200 text-gray-800 border-gray-400';
            default:         return 'bg-orange-100 text-orange-800 border-orange-300';
        }
    }

    // 3. Mendapatkan Gambar Badge (Disinkronkan dengan Batch Baru)
    public function getBadgeImageAttribute()
    {
        // Kita gunakan logic Batch agar sinkron (Master, Platinum, dll)
        $rank = $this->batch; 

        switch ($rank) {
            case 'Master':   
                // Menggunakan gambar diamond.jpg untuk rank tertinggi (Master)
                return asset('img/diamond.jpg'); 
            case 'Platinum': 
                return asset('img/platinum.png');
            case 'Gold':     
                return asset('img/gold.png');
            case 'Silver':   
                return asset('img/silver.png');
            default:         
                return asset('img/bronze.png');
        }
    }

    // 4. Mendapatkan Label Rank (Untuk kompatibilitas)
    public function getRankLabelAttribute()
    {
        // Langsung kembalikan nilai batch agar konsisten
        return $this->batch;
    }
    
}