<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // 1. Menampilkan Formulir Pembuatan Akun
    public function create()
    {
        return view('users.create');
    }

    // 2. Proses Menyimpan Data ke Database
    public function store(Request $request)
    {
        // Validasi input dulu (Wajib diisi)
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'role' => 'required',
            'password' => 'required|string|min:8',
        ]);

        // Simpan ke Database
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            // Poin & Level otomatis default dari database (0 & Novice)
            'password' => Hash::make($request->password), 
        ]);

        // Setelah simpan, kembalikan ke dashboard dengan pesan sukses
        return redirect('/dashboard')->with('success', 'Akun berhasil dibuat!');
    }
}