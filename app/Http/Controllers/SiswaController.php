<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Materi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Soal;
use App\Models\ShopItem;
use App\Models\ShopTransaction;
use Illuminate\Support\Facades\DB;

class SiswaController extends Controller
{
    // ==========================================
    // BAGIAN 1: FITUR ADMIN / GURU (MANAJEMEN DATA)
    // ==========================================

    public function index()
    {
        // Cek jika yang akses bukan admin/guru
        if (Auth::user()->role === 'siswa') {
            return redirect()->route('siswa.dashboard');
        }

        $siswas = User::where('role', 'siswa')->get();
        return view('admin.siswas.index', compact('siswas'));
    }

    public function create()
    {
        return view('admin.siswas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'siswa',
            'points' => 0,
            'level' => 1,
        ]);

        return redirect()->route('siswas.index')->with('success', 'Siswa berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $siswa = User::findOrFail($id);
        return view('admin.siswas.edit', compact('siswa'));
    }

    public function update(Request $request, $id)
    {
        $siswa = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$siswa->id,
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $siswa->update($data);

        return redirect()->route('siswas.index')->with('success', 'Data siswa diperbarui!');
    }

    public function destroy($id)
    {
        $siswa = User::findOrFail($id);
        $siswa->delete();
        return redirect()->route('siswas.index')->with('success', 'Siswa berhasil dihapus!');
    }


    // ==========================================
    // BAGIAN 2: FITUR KHUSUS SISWA (DASHBOARD & BELAJAR)
    // ==========================================

    public function dashboard()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Ambil Materi & Progress
        $materis = Materi::all();
        foreach($materis as $materi) {
            $progress = $user->materis()->where('materi_id', $materi->id)->first();
            $materi->sudah_nonton = $progress ? $progress->pivot->is_watched : false;
            $materi->nilai_kuis = $progress ? $progress->pivot->quiz_score : null;
        }

        // Leaderboard (Top 5)
        $leaderboard = User::where('role', 'siswa')
                            ->orderBy('points', 'desc')
                            ->take(5)
                            ->get();

        // Shop Items (Hanya yang aktif)
        $shopItems = ShopItem::where('is_active', true)->get();

        return view('siswa.dashboard', compact('user', 'materis', 'leaderboard', 'shopItems'));
    }

    public function buyShopItem(Request $request, $itemId)
    {
        $user = Auth::user();
        $item = ShopItem::findOrFail($itemId);

        // Validasi Stok
        if ($item->stock <= 0) {
            return redirect()->back()->with('error', 'Stok barang ini sudah habis! 😭');
        }

        // Validasi Saldo
        if ($user->points < $item->price) {
            return redirect()->back()->with('error', 'XP kamu tidak cukup! Ayo kumpulkan lagi! 💪');
        }

        // Proses Transaksi Aman
        DB::beginTransaction();
        try {
            // 1. Potong Poin Siswa
            $user->decrement('points', $item->price);

            // 2. Kurangi Stok Barang
            $item->decrement('stock', 1);

            // 3. Catat Riwayat Transaksi
            ShopTransaction::create([
                'user_id' => $user->id,
                'shop_item_id' => $item->id,
                'price_at_purchase' => $item->price,
                'status' => 'approved'
            ]);

            DB::commit();
            return redirect()->back()->with('success', 'Berhasil menukar ' . $item->price . ' XP dengan ' . $item->name . '! 🎉');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat transaksi.');
        }
    }

    public function showMateri($id)
    {
        $materi = Materi::findOrFail($id);
        return view('siswa.materi.show', compact('materi'));
    }

    public function completeMateri($id)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $materi = Materi::findOrFail($id);

        $user->materis()->syncWithoutDetaching([
            $materi->id => ['is_watched' => true]
        ]);

        return redirect()->route('siswa.dashboard')->with('success', 'Selamat! Anda telah menyelesaikan materi ini. Kuis terbuka!');
    }

    public function leaderboard()
    {
        $leaderboard = User::where('role', 'siswa')
                            ->orderBy('points', 'desc')
                            ->get();

        return view('siswa.leaderboard', compact('leaderboard'));
    }

    // ==========================================
    // BAGIAN 3: SISTEM KUIS
    // ==========================================

    // 1. Menampilkan Halaman Peraturan (Pre-Quiz)
    public function preKuis($id)
    {
        $user = Auth::user();
        $materi = Materi::findOrFail($id);

        // Cek jika sudah mengerjakan
        $progress = $user->materis()->where('materi_id', $id)->first();
        if ($progress && $progress->pivot->quiz_score !== null) {
            return redirect()->route('siswa.kuis.hasil', $id);
        }

        return view('siswa.materi.pre_quiz', compact('materi'));
    }

    // 2. Menampilkan Halaman Soal
    public function showKuis($id)
    {
       $user = Auth::user();
       $materi = Materi::findOrFail($id);

       // Cek Score (Anti-Cheat)
       $progress = $user->materis()->where('materi_id', $id)->first();
       if ($progress && $progress->pivot->quiz_score !== null) {
           return redirect()->route('siswa.kuis.hasil', $id);
       }

       $soals = Soal::where('materi_id', $id)->inRandomOrder()->get();

       return view('siswa.materi.kuis', compact('materi', 'soals'));
    }

    // 3. Proses Submit Jawaban & Hitung Nilai
    public function submitKuis(Request $request, $id)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $materi = Materi::findOrFail($id);

        $jawabanSiswa = $request->input('jawaban');
        $soals = Soal::where('materi_id', $id)->get();

        $totalSkor = 0;
        $jumlahBenar = 0;

        $poinConfig = [
            'easy' => 1,
            'medium' => 2,
            'hard' => 3
        ];

        foreach ($soals as $soal) {
            $levelRaw = $soal->difficulty ?? 'easy';
            $level = strtolower($levelRaw);

            // Logika Cek Jawaban (Case Insensitive)
            // Pastikan kolom di DB bernama 'correct_answer'
            if (isset($jawabanSiswa[$soal->id]) && strcasecmp($jawabanSiswa[$soal->id], $soal->correct_answer) == 0) {
                $points = $poinConfig[$level] ?? 1;
                $totalSkor += $points;
                $jumlahBenar++;
            }
        }

        $nilai = $totalSkor; // Skor total berdasarkan bobot kesulitan
        $poinDidapat = $nilai; // Poin gamifikasi sama dengan nilai

        // Simpan Hasil ke Pivot Table
        $user->materis()->syncWithoutDetaching([
            $materi->id => [
                'quiz_score' => $nilai,
                'is_watched' => true
            ]
        ]);

        // Tambah Poin ke User
        $user->increment('points', $poinDidapat);

        return view('siswa.materi.hasil_kuis', [
            'materi' => $materi,
            'nilai' => $nilai,
            'benar' => $jumlahBenar,
            'total_soal' => $soals->count(),
            'poin' => $poinDidapat
        ]);
    }

    // 4. Menampilkan Halaman Hasil Akhir
    public function hasilKuis($id)
    {
        $user = Auth::user();
        $materi = Materi::findOrFail($id);

        $progress = $user->materis()->where('materi_id', $id)->first();

        // Jika belum mengerjakan tapi maksa masuk sini
        if (!$progress || $progress->pivot->quiz_score === null) {
            return redirect()->route('siswa.kuis.pre', $id);
        }

        $nilai = $progress->pivot->quiz_score;

        return view('siswa.materi.hasil_kuis', compact('materi', 'nilai'));
    }

}
