<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('raid_events', function (Blueprint $table) {
            $table->integer('timer_seconds')->default(30)->after('status');
        });
    }

    public function down()
    {
        Schema::table('raid_events', function (Blueprint $table) {
            $table->dropColumn('timer_seconds');
        });
    }
};
