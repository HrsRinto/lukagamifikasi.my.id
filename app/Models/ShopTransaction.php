<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopTransaction extends Model
{
    use HasFactory;

    protected $guarded = []; // Agar bisa create data dengan leluasa

    // Relasi ke User (Siswa)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Barang Shop
    // Kita namakan 'item' supaya mudah dipanggil di view ($trx->item->name)
    public function item()
    {
        return $this->belongsTo(ShopItem::class, 'shop_item_id');
    }
}