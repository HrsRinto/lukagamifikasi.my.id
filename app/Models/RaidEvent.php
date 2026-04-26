<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class RaidEvent extends Model {
    protected $guarded = [];

    public function soals() {
        return $this->hasMany(RaidSoal::class);
    }

    public function participants() {
        return $this->hasMany(RaidParticipant::class)->orderBy('damage_dealt', 'desc');
    }
}
