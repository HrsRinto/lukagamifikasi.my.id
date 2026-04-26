<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('soals', function (Blueprint $table) {
            $table->id();
            
            // Penghubung ke Materi
            $table->foreignId('materi_id')->constrained('materis')->onDelete('cascade');

            // Data Soal (Bahasa Inggris)
            $table->text('question');
            $table->string('option_a');
            $table->string('option_b');
            $table->string('option_c');
            $table->string('option_d');
            $table->char('correct_answer', 1); // A, B, C, D
            
            // INI YANG MENYEBABKAN ERROR TADI (Sekarang kita buat kolomnya)
            $table->string('kategori'); // easy, medium, hard
            $table->integer('points');  // 1, 2, atau 3
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('soals');
    }
};