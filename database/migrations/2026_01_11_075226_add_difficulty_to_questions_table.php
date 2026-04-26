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
        // GANTI 'questions' JADI 'soals'
        Schema::table('soals', function (Blueprint $table) {
            $table->enum('difficulty', ['easy', 'medium', 'hard'])->default('easy');
        });
    }

    public function down()
    {
        // GANTI 'questions' JADI 'soals'
        Schema::table('soals', function (Blueprint $table) {
            $table->dropColumn('difficulty');
        });
    }
};
