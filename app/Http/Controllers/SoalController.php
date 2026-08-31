<?php

namespace App\Http\Controllers;

use App\Models\Soal;
use App\Models\Materi;
use Illuminate\Http\Request;

class SoalController extends Controller
{
    public function index()
    {
        $soals = Soal::orderBy('materi_id', 'asc')->get();
        return view('guru.soals.index', compact('soals'));
    }

    // Function CREATE (Menampilkan Form)
    public function create(Request $request)
    {
        // 1. Cek Materi Terpilih
        $materi_id = $request->query('materi_id');
        $materi_terpilih = null;
        $nomor_soal = 1; // Default no 1
        $kategori_otomatis = 'easy';
        $poin_otomatis = 1;

        if($materi_id){
            $materi_terpilih = Materi::find($materi_id);
            
            // 2. HITUNG JUMLAH SOAL YANG SUDAH ADA
            $jumlah_soal_ada = Soal::where('materi_id', $materi_id)->count();
            $nomor_soal = $jumlah_soal_ada + 1; // Soal berikutnya

            // 3. LOGIKA LEVEL OTOMATIS (1-5 Easy, 6-10 Medium, 11-15 Hard)
            if($nomor_soal <= 5) {
                $kategori_otomatis = 'easy';
                $poin_otomatis = 1;
            } elseif($nomor_soal <= 10) {
                $kategori_otomatis = 'medium';
                $poin_otomatis = 2;
            } else {
                $kategori_otomatis = 'hard';
                $poin_otomatis = 3;
            }

            // Jika sudah lebih dari 15, arahkan kembali ke dashboard (Selesai)
            if($nomor_soal > 15) {
                return redirect()->route('dashboard')->with('success', 'Selamat! Anda telah menyelesaikan input 15 soal untuk materi ini.');
            }
        }

        return view('guru.soals.create', compact('materi_terpilih', 'nomor_soal', 'kategori_otomatis', 'poin_otomatis'));
    }

   public function store(Request $request)
    {
        // 1. PERBAIKAN VALIDASI (Dibuat agar bisa menerima input lama & baru)
        $request->validate([
            'materi_id'     => 'required',
            'pertanyaan'    => 'required',
            'pilihan_a'     => 'required',
            'pilihan_b'     => 'required',
            'pilihan_c'     => 'required',
            'pilihan_d'     => 'required',
            'kunci_jawaban' => 'required',
            
            // SAYA HAPUS 'difficulty' => 'required' AGAR TIDAK EROR SAAT PAKAI FORM LAMA
            // Sebagai gantinya, kita izinkan kategori atau difficulty boleh ada
            'kategori'      => 'nullable', 
            'difficulty'    => 'nullable',
        ]);

        // 2. LOGIKA PENYELAMAT DATA (PENTING!)
        // Ambil data 'difficulty'. Jika kosong, ambil dari 'kategori'.
        // Ini adalah jembatan agar tampilan lama Anda tetap bisa masuk ke database baru.
        $level = $request->difficulty ?? $request->kategori;

        // Jika keduanya kosong (jaga-jaga), kita set default ke 'easy'
        if(!$level) {
            $level = 'easy';
        }

        // Hitung Poin berdasarkan level yang sudah ditemukan tadi
        $poin = 1; // Default Easy
        if($level == 'medium') $poin = 2;
        if($level == 'hard')   $poin = 3;

        // 3. SIMPAN KE DATABASE
        Soal::create([
            'materi_id'      => $request->materi_id,
            
            // Mapping: Kiri (Database Inggris) => Kanan (Form Indo)
            'question'       => $request->pertanyaan,
            'option_a'       => $request->pilihan_a,
            'option_b'       => $request->pilihan_b,
            'option_c'       => $request->pilihan_c,
            'option_d'       => $request->pilihan_d,
            'correct_answer' => $request->kunci_jawaban,
            
            // Kita simpan $level ke kedua kolom agar aman
            'kategori'       => $level, 
            'points'         => $poin,    
            'difficulty'     => $level,
        ]);

        // 4. ALGORITMA PENGECEKAN 15 SOAL (TIDAK SAYA UBAH)
        // Hitung total soal yang sudah ada di materi ini
        $total_soal = Soal::where('materi_id', $request->materi_id)->count();

        if($total_soal >= 15) {
            // JIKA SUDAH 15 SOAL -> SELESAI (Ke Dashboard)
            return redirect()->route('dashboard')->with('success', 'Sempurna! 15 Soal berhasil dibuat.');
        } else {
            // JIKA BELUM 15 -> LANJUT KE SOAL BERIKUTNYA
            return redirect()->route('soals.create', ['materi_id' => $request->materi_id])
                ->with('success', 'Soal No ' . $total_soal . ' tersimpan. Lanjut ke Soal No ' . ($total_soal + 1));
        }
    }

    public function edit($id)
    {
        $soal = Soal::findOrFail($id);
        return view('guru.soals.edit', compact('soal'));
    }

    public function update(Request $request, $id)
    {
        $soal = Soal::findOrFail($id);
        
        // 1. LOGIKA UPDATE POIN (Tanpa merubah algoritma lama)
        // Kita ambil input 'difficulty' (dari form baru) atau 'kategori' (dari kode lama)
        $levelInput = $request->difficulty ?? $request->kategori;
        
        $poin = $soal->points; // Default pakai nilai lama

        if($levelInput){
             if($levelInput == 'easy') $poin = 1;
             elseif ($levelInput == 'medium') $poin = 2;
             elseif ($levelInput == 'hard') $poin = 3;
        }

        // 2. UPDATE DATABASE
        // Saya sesuaikan nama kolom (sisi kiri) dengan database 'pertanyaan', 'opsi_a' dsb
        // agar tidak error "Column not found".
        $soal->update([
            'materi_id'      => $request->materi_id ?? $soal->materi_id,
            
            'question'       => $request->pertanyaan ?? $soal->question,
            'option_a'       => $request->pilihan_a ?? $soal->option_a,
            'option_b'       => $request->pilihan_b ?? $soal->option_b,
            'option_c'       => $request->pilihan_c ?? $soal->option_c,
            'option_d'       => $request->pilihan_d ?? $soal->option_d,
            'correct_answer' => $request->kunci_jawaban ?? $soal->correct_answer,
            
            // Kolom difficulty (sesuai migrasi Anda)
            'difficulty'     => $request->difficulty ?? $soal->difficulty,
            'points'         => $poin,
        ]);

        // Redirect kembali ke halaman detail materi (materis.show) agar langsung mengelola materi & soal terkait
        return redirect()->route('materis.show', $soal->materi_id)->with('success', 'Soal berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $soal = Soal::findOrFail($id);
        $materi_id = $soal->materi_id;
        $soal->delete();
        // Redirect kembali ke halaman detail materi (materis.show)
        return redirect()->route('materis.show', $materi_id)->with('success', 'Soal berhasil dihapus!');
    }
}