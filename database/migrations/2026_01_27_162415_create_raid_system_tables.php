<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // 1. Tabel Event (Raid Boss)
        Schema::create('raid_events', function (Blueprint $table) {
            $table->id();
            $table->string('mafia_name'); // Nama Boss (Misal: Don Corleone)
            $table->integer('total_hp')->default(35); // Darah Awal (35)
            $table->integer('current_hp')->default(35); // Darah Saat Ini
            $table->enum('status', ['closed', 'lobby', 'live', 'finished'])->default('closed');
            // closed: Guru belum buka
            // lobby: Guru buka room, siswa bisa masuk (mirip PUBG room)
            // live: Perang dimulai!
            // finished: Boss mati, lihat leaderboard
            $table->timestamps();
        });

        // 2. Tabel Soal Khusus Raid (Terpisah dari soal materi biasa)
        Schema::create('raid_soals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('raid_event_id')->constrained()->onDelete('cascade');
            $table->text('pertanyaan');
            $table->string('opsi_a');
            $table->string('opsi_b');
            $table->string('opsi_c');
            $table->string('opsi_d');
            $table->string('kunci_jawaban'); // a, b, c, atau d
            $table->timestamps();
        });

        // 3. Tabel Partisipan (Untuk Leaderboard Khusus & Tracking Damage)
        Schema::create('raid_participants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('raid_event_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('damage_dealt')->default(0); // Total jawaban benar
            $table->timestamp('joined_at')->useCurrent();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('raid_participants');
        Schema::dropIfExists('raid_soals');
        Schema::dropIfExists('raid_events');
    }
};
