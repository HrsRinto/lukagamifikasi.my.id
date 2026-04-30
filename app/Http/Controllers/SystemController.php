<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class SystemController extends Controller
{
    /**
     * Safely attempts to fix database migration issues.
     */
    public function repairDatabase()
    {
        try {
            // 1. Tambahkan kolom yang mungkin kurang secara manual (Brute Force Fix)
            // Ini untuk mengatasi masalah "Column not found" yang Anda alami
            
            // Perbaikan untuk tabel Users
            DB::statement("ALTER TABLE users ADD COLUMN IF NOT EXISTS profile_photo_url TEXT NULL AFTER profile_photo_path");
            
            // Perbaikan untuk tabel Raid Events
            if (Schema::hasTable('raid_events')) {
                if (!Schema::hasColumn('raid_events', 'created_at')) {
                    DB::statement("ALTER TABLE raid_events ADD COLUMN created_at TIMESTAMP NULL");
                }
                if (!Schema::hasColumn('raid_events', 'updated_at')) {
                    DB::statement("ALTER TABLE raid_events ADD COLUMN updated_at TIMESTAMP NULL");
                }
            }

            // Perbaikan untuk tabel Raid Participants
            if (Schema::hasTable('raid_participants')) {
                if (!Schema::hasColumn('raid_participants', 'created_at')) {
                    DB::statement("ALTER TABLE raid_participants ADD COLUMN created_at TIMESTAMP NULL");
                }
                if (!Schema::hasColumn('raid_participants', 'updated_at')) {
                    DB::statement("ALTER TABLE raid_participants ADD COLUMN updated_at TIMESTAMP NULL");
                }
            }

            // 2. Coba jalankan migrasi standar jika masih ada yang kurang
            Artisan::call('migrate', ['--force' => true]);

            return redirect()->route('dashboard')->with('success', 'Database berhasil diperbaiki secara paksa!');
        } catch (\Exception $e) {
            return response()->view('errors.database', [
                'message' => 'Gagal memperbaiki database.',
                'error_detail' => $e->getMessage()
            ], 500);
        }
    }
}
