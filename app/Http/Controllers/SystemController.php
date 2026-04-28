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
            // 1. Pastikan tabel migrations ada
            if (!Schema::hasTable('migrations')) {
                Artisan::call('migrate:install', ['--force' => true]);
            }

            // 2. Jalankan migrasi
            // Kita coba jalankan secara umum dulu
            Artisan::call('migrate', ['--force' => true]);

            return redirect()->route('dashboard')->with('success', 'Database berhasil diperbaiki dan diperbarui!');
        } catch (\Exception $e) {
            $message = $e->getMessage();
            
            // Jika errornya adalah "table already exists", kita bisa mencoba menandai migrasi tersebut sebagai selesai
            // Tapi yang paling aman adalah memberikan pesan error yang jelas ke user.
            return response()->view('errors.database', [
                'message' => 'Gagal memperbaiki database secara otomatis.',
                'error_detail' => $message,
                'solution' => 'Sepertinya ada ketidaksinkronan antara tabel fisik dan catatan migrasi. Jika ini database baru, Anda bisa mencoba mengosongkan database dan menjalankan ulang.'
            ], 500);
        }
    }
}
