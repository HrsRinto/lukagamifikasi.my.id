<?php

namespace App\Http\Controllers;

use App\Models\Materi;
use Illuminate\Http\Request;

class MateriController extends Controller
{
    // 1. TAMPILKAN DAFTAR MATERI
    public function index()
    {
        // Ambil materi beserta JUMLAH SOALNYA (withCount)
        $materis = Materi::withCount('soals')->orderBy('created_at', 'desc')->get();
        return view('guru.materis.index', compact('materis'));
    }

    // FUNGSI BARU: Untuk halaman "Detail Modul" (Edit Video + List Soal)
    public function show($id)
    {
        $materi = Materi::with('soals')->findOrFail($id);
        return view('guru.materis.show', compact('materi'));
    }

    // 2. FORM TAMBAH MATERI
    public function create()
    {
        return view('guru.materis.create');
    }

    // 3. SIMPAN MATERI BARU
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'video_url' => 'required',
        ]);

        // 1. Simpan Materi
        $materi = \App\Models\Materi::create([
            'title' => $request->title,
            'description' => $request->description,
            'video_url' => $request->video_url,
        ]);

        // 2. REDIRECT KHUSUS: Langsung ke halaman buat soal membawa ID Materi
        return redirect()->route('soals.create', ['materi_id' => $materi->id])
            ->with('success', 'Materi berhasil dibuat! Silakan langsung input soal untuk materi ini.');
    }

    // 4. FORM EDIT MATERI
    public function edit($id)
    {
        $materi = Materi::findOrFail($id);
        return view('guru.materis.edit', compact('materi'));
    }

    // 5. UPDATE MATERI
    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'link_youtube' => 'required|url',
            'deskripsi' => 'required|string',
        ]);

        $materi = Materi::findOrFail($id);
        $materi->update($request->all());

        return redirect()->route('materis.index')->with('success', 'Materi berhasil diperbarui!');
    }

    // 6. HAPUS MATERI
    public function destroy($id)
    {
        $materi = Materi::findOrFail($id);
        $materi->delete();

        return redirect()->route('materis.index')->with('success', 'Materi dihapus!');
    }
}