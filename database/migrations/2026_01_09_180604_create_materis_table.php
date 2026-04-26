<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('materis', function (Blueprint $table) {
            $table->id();
            
            // UBAH DARI 'judul' MENJADI 'title'
            $table->string('title'); 
            
            // UBAH DARI 'deskripsi' MENJADI 'description'
            $table->text('description'); 
            
            // Pastikan ini video_url (bukan link_video)
            $table->string('video_url'); 
            
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materis');
    }
};
