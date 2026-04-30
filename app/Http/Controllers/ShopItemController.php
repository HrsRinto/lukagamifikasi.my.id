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

            // 2. Ambil riwayat transaksi (Eager load user & item untuk performa)
            $transactions = ShopTransaction::with(['user', 'item'])->latest()->limit(30)->get();

            // 3. Kirim ke View
            return view('guru.shop.index', compact('items', 'transactions'));
        } catch (\Exception $e) {
            return response()->view('errors.database', [
                'error_detail' => $e->getMessage()
            ], 500);
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
            'image_url' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['name', 'price', 'stock', 'description']);

        // Jika ada Image URL
        if ($request->image_url) {
            $data['image'] = $request->image_url;
        } 
        // Jika ada upload file
        elseif ($request->hasFile('image')) {
            $path = $request->file('image')->store('shop-items', 'public');
            $data['image'] = $path;
        }

        ShopItem::create($data);

        return redirect()->back()->with('success', 'Barang berhasil ditambahkan!');
    }

    // Update Barang
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|integer|min:1',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image_url' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $item = ShopItem::findOrFail($id);
        $data = $request->only(['name', 'price', 'stock', 'description']);

        // Jika ada Image URL, prioritaskan itu
        if ($request->image_url) {
            $data['image'] = $request->image_url;
        } 
        // Jika ada upload file
        elseif ($request->hasFile('image')) {
            // Hapus gambar lama jika ada di storage
            if ($item->image && !filter_var($item->image, FILTER_VALIDATE_URL)) {
                Storage::disk('public')->delete($item->image);
            }
            $path = $request->file('image')->store('shop-items', 'public');
            $data['image'] = $path;
        }

        $item->update($data);

        return redirect()->back()->with('success', 'Barang berhasil diperbarui!');
    }

    // Hapus Barang
    public function destroy($id)
    {
        $item = ShopItem::findOrFail($id);
        
        if ($item->image && !filter_var($item->image, FILTER_VALIDATE_URL)) {
            Storage::disk('public')->delete($item->image);
        }
        
        $item->delete();

        return redirect()->back()->with('success', 'Barang dihapus.');
    }
}