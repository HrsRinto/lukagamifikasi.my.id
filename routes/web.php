<?php
// Test update untuk trigger GitHub Desktop

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\MateriController;
use App\Http\Controllers\SoalController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\RaidController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Route untuk perbaikan database (Safe Migration)
Route::get('/admin/repair-db', [\App\Http\Controllers\SystemController::class, 'repairDatabase'])->name('admin.repair-db');

Route::get('/', function () {
    // Jika user sudah login, arahkan ke dashboard
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    // HAPUS HURUF 's' DI SINI

    // Jika belum, arahkan ke halaman login
    return redirect()->route('login');
});

// --- LOGIKA DASHBOARD (PENGARAHAN USER) ---
Route::get('/dashboard', function () {
    $user = Auth::user();
    $role = $user->role;

    if ($role === 'admin') {
        return view('dashboard');
    } elseif ($role === 'guru') {
        return redirect()->route('guru.dashboard');
    } else {
        return redirect()->route('siswa.dashboard');
    }
})->middleware(['auth', 'verified'])->name('dashboard');

// Route khusus Dashboard Guru (dengan Controller)
Route::get('/guru/dashboard', [GuruController::class, 'dashboard'])
    ->middleware(['auth', 'verified'])
    ->name('guru.dashboard');

// GROUP MIDDLEWARE (Hanya user login yang bisa akses ini)
Route::middleware('auth')->group(function () {
    // Route Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Route Users (Create & Store)
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');

    // Resources
    Route::resource('gurus', GuruController::class);
    Route::resource('siswas', SiswaController::class);
    Route::resource('materis', MateriController::class);
    Route::resource('soals', SoalController::class);

    // Leaderboard
    Route::get('/leaderboard', [LeaderboardController::class, 'index'])->name('leaderboard.index');

    // Route Khusus Upload Foto
    Route::post('/profile/photo', [ProfileController::class, 'updatePhoto'])->name('profile.photo.update');

    // Route Siswa
    Route::get('/dashboard-siswa', [SiswaController::class, 'dashboard'])->name('siswa.dashboard');

    Route::get('/materi/{id}', [SiswaController::class, 'showMateri'])->name('siswa.materi.show');
    Route::post('/materi/{id}/complete', [SiswaController::class, 'completeMateri'])->name('siswa.materi.complete');
    Route::get('/siswa/leaderboard', [SiswaController::class, 'leaderboard'])->name('siswa.leaderboard');
    Route::get('/siswa/materi/{id}/kuis', [App\Http\Controllers\SiswaController::class, 'showKuis'])->name('siswa.materi.kuis');
    Route::get('/leaderboard', [LeaderboardController::class, 'index'])->name('leaderboard');
    Route::get('/siswa/materi/{id}/kuis', [SiswaController::class, 'showKuis'])->name('siswa.kuis.show');
    Route::post('/siswa/materi/{id}/kuis', [SiswaController::class, 'submitKuis'])->name('siswa.kuis.submit');
    Route::resource('shop-guru', \App\Http\Controllers\ShopItemController::class);
    Route::post('/shop/buy/{id}', [SiswaController::class, 'buyShopItem'])->name('siswa.shop.buy');
    Route::get('/materi/{id}/peraturan-kuis', [SiswaController::class, 'preKuis'])->name('siswa.kuis.pre');
    Route::get('/materi/{id}/kuis', [SiswaController::class, 'showKuis'])->name('siswa.kuis.show');
    Route::get('/materi/{id}/hasil', [SiswaController::class, 'hasilKuis'])->name('siswa.kuis.hasil');


    // RAID SYSTEM
Route::prefix('raid')->name('siswa.raid.')->group(function () {
    Route::get('/', [RaidController::class, 'indexSiswa'])->name('index');
    Route::get('/lobby-data', [RaidController::class, 'getLobbyData'])->name('lobby_data'); // AJAX Polling
    Route::get('/get-soal', [RaidController::class, 'getSoal'])->name('get_soal');
    Route::get('/get-hp', [RaidController::class, 'getBossHP'])->name('get_hp');
    Route::post('/attack', [RaidController::class, 'attackBoss'])->name('attack');
});

Route::group(['prefix' => 'shop-guru', 'as' => 'shop-guru.', 'middleware' => ['auth', 'role:guru']], function () {
    Route::get('/', [ShopItemController::class, 'index'])->name('index');
    Route::post('/', [ShopItemController::class, 'store'])->name('store');
    Route::patch('/{id}', [ShopItemController::class, 'update'])->name('update');
    Route::delete('/{id}', [ShopItemController::class, 'destroy'])->name('destroy');
});

Route::prefix('guru/raid')->name('guru.raid.')->group(function () {
    Route::get('/', [RaidController::class, 'indexGuru'])->name('index');
    Route::post('/update-status', [RaidController::class, 'updateStatus'])->name('update_status');
    Route::post('/store-soal', [RaidController::class, 'storeSoal'])->name('store_soal');
    Route::delete('/soal/{id}', [RaidController::class, 'destroySoal'])->name('destroy_soal');
    Route::post('/reset', [RaidController::class, 'resetEvent'])->name('reset');
    Route::post('/import/{id}', [RaidController::class, 'importSoal'])->name('import_soal');
    Route::post('/update-timer', [RaidController::class, 'updateTimer'])->name('update_timer');

    Route::get('/monitor', [RaidController::class, 'monitor'])->name('monitor');
    Route::post('/update-hp', [RaidController::class, 'updateBossHP'])->name('update_hp');
    Route::get('/monitor-data', [RaidController::class, 'getMonitorData'])->name('get_monitor_data');
});


});

require __DIR__.'/auth.php';
