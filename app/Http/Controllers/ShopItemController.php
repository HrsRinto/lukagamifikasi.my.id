<?php

namespace App\Http\Controllers;

use App\Models\ShopItem;
use App\Models\ShopTransaction; // <--- Pastikan ini ada
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ShopItemController extends Controller
{
    // Menampilkan halaman Shop Guru
    public function index()
    {
        try {
            // 1. Ambil semua barang
            $items = ShopItem::latest()->get();

            // 2. Ambil riwayat transaksi (agar Guru bisa lihat siapa yang beli)
            $transactions = ShopTransaction::with(['user', 'item'])->latest()->get();

            // 3. Kirim ke View
            return view('guru.shop.index', compact('items', 'transactions'));
        } catch (\Illuminate\Database\QueryException $e) {
            // FITUR OTOMATIS: Coba jalankan migrasi jika tabel tidak ditemukan
            try {
                \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
                return redirect()->refresh()->with('success', 'Database berhasil disiapkan secara otomatis!');
            } catch (\Exception $ex) {
                return response()->view('errors.database', ['message' => 'Gagal menjalankan migrasi otomatis: ' . $ex->getMessage()], 500);
            }
        }
    }

    // Simpan Barang Baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|integer|min:1',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();

        // Upload Gambar
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('shop-items', 'public');
            $data['image'] = $path;
        }

        ShopItem::create($data);

        return redirect()->back()->with('success', 'Barang berhasil ditambahkan!');
    }

    // Hapus Barang
    public function destroy($id)
    {
        $item = ShopItem::findOrFail($id);
        
        if ($item->image) {
            Storage::disk('public')->delete($item->image);
        }
        
        $item->delete();

        return redirect()->back()->with('success', 'Barang dihapus.');
    }
}