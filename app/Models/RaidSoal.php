<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RaidSoal extends Model
{
    protected $guarded = [];

    // Relasi balik ke Event
    public function event()
    {
        return $this->belongsTo(RaidEvent::class, 'raid_event_id');
    }
}
