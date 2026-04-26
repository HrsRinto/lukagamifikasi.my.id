<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shop_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Siapa yang beli (Siswa)
            $table->foreignId('shop_item_id')->constrained()->onDelete('cascade'); // Barang apa
            $table->integer('price_at_purchase'); // Harga saat dibeli (untuk history jika harga berubah)
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending'); // Status penukaran
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shop_transactions');
    }
};