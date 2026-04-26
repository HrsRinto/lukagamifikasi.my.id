<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shop_items', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama Barang (misal: Kartu Bebas Soal)
            $table->text('description')->nullable(); // Deskripsi manfaat
            $table->integer('price'); // Harga dalam XP
            $table->integer('stock')->default(0); // Jumlah stok tersedia
            $table->string('image')->nullable(); // Foto barang (opsional)
            $table->boolean('is_active')->default(true); // Status aktif/tidak
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shop_items');
    }
};