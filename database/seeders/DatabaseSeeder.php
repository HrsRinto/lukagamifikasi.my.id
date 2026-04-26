<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Materi;
use App\Models\Soal;
use App\Models\RaidEvent; // <--- TAMBAHAN: Import Model RaidEvent
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. BUAT AKUN ADMINISTRATOR (Permintaan Khusus Anda)
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@sekolah.com',
            'password' => Hash::make('adminsekolah123'), // Password sesuai request
            'role' => 'admin', // Role admin
        ]);

        // 2. BUAT AKUN GURU (Tambahan)
        User::create([
            'name' => 'Guru Bambang',
            'email' => 'guruBambang@sekolah.com',
            'password' => Hash::make('bambang1212'),
            'role' => 'guru',
        ]);

        // 2. BUAT AKUN SISWA (Sesuai gambar Anda)
        $rinto = User::create([
            'name' => 'Hironimus Rinto',
            'email' => 'rinto@sekolah.com',
            'password' => Hash::make('rinto123'),
            'role' => 'siswa',
            'points' => 0,
            'level' => 1,
        ]);

        User::create([
            'name' => 'Daryl',
            'email' => 'Daryl@sekolah.com',
            'password' => Hash::make('daryl123'),
            'role' => 'siswa',
            'points' => 0,
            'level' => 1,
        ]);

        User::create([
            'name' => 'Xaferius',
            'email' => 'Xaferius@sekolah.com',
            'password' => Hash::make('xaferius123'),
            'role' => 'siswa',
            'points' => 0,
            'level' => 1,
        ]);

        User::create([
            'name' => 'Andi Siswa',
            'email' => 'siswa@sekolah.com',
            'password' => Hash::make('andi123'),
            'role' => 'siswa',
            'points' => 0,
            'level' => 1,
        ]);

        // ==========================================
        // 3. TAMBAHAN KHUSUS: DATA AWAL RAID MAFIA
        // ==========================================
        // Ini wajib ada agar Controller tidak error saat mencari RaidEvent::first()

        RaidEvent::create([
            'mafia_name' => 'Don Corleone', // Nama Boss Awal
            'total_hp' => 35,               // Darah total sesuai request (35)
            'current_hp' => 35,             // Darah saat ini (Penuh)
            'status' => 'closed',           // Status awal tertutup
        ]);

    }
}
