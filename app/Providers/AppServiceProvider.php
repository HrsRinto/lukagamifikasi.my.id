<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;   // <--- Penting untuk View::composer
use Illuminate\Support\Facades\Schema; // <--- Penting untuk Schema::hasTable (INI YANG KURANG KEMARIN)
use App\Models\ShopItem;               // <--- Penting untuk panggil Model ShopItem

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        // Jika di Vercel, paksa HTTPS
        if (config('app.env') === 'production') {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }
        // LOGIKA BARU:
        // Setiap kali file 'layouts.navigation' dimuat (di halaman manapun),
        // otomatis kirimkan data $shopItems yang aktif.
        
        View::composer('layouts.navigation', function ($view) {
            // Cek dulu apakah tabel shop_items sudah ada di database
            // (Penting agar tidak error saat kita menjalankan 'php artisan migrate' dari nol)
            if (Schema::hasTable('shop_items')) {
                $shopItems = ShopItem::where('is_active', true)->get();
                $view->with('shopItems', $shopItems);
            }
        });
    }
}