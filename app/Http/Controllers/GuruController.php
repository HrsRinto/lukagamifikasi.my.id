<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class GuruController extends Controller
{
    /**
     * Tampilkan Dashboard Guru dengan Statistik
     */
    public function dashboard()
    {
        $stats = [
            'total_siswa' => \App\Models\User::where('role', 'siswa')->count(),
            'total_materi' => \App\Models\Materi::count(),
            'total_soal' => \App\Models\Soal::count(),
        ];

        return view('guru.dashboard', compact('stats'));
    }

    // 1. MENAMPILKAN DAFTAR GURU
    public function index()
    {
        // Ambil semua user yang role-nya 'guru'
        $gurus = User::where('role', 'guru')->get();
        return view('admin.gurus.index', compact('gurus'));
    }

    // 2. MENAMPILKAN FORM TAMBAH
    public function create()
    {
        return view('admin.gurus.create');
    }

    // 3. MENYIMPAN DATA GURU BARU
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
            'role' => 'guru', // Otomatis set role jadi guru
        ]);

        return redirect()->route('gurus.index')->with('success', 'Guru berhasil ditambahkan!');
    }

    // 4. MENAMPILKAN FORM EDIT
    public function edit($id)
    {
        $guru = User::findOrFail($id);
        return view('admin.gurus.edit', compact('guru'));
    }

    // 5. UPDATE DATA GURU
    public function update(Request $request, $id)
    {
        $guru = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$guru->id,
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        // Cek jika password diisi, baru diupdate
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $guru->update($data);

        return redirect()->route('gurus.index')->with('success', 'Data Guru diperbarui!');
    }

    // 6. HAPUS GURU
    public function destroy($id)
    {
        $guru = User::findOrFail($id);
        $guru->delete();

        return redirect()->route('gurus.index')->with('success', 'Guru berhasil dihapus!');
    }
}