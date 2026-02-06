<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = ['floor_id', 'room_category_id', 'room_number', 'status'];

    public function floor()
    {
        return $this->belongsTo(Floor::class);
    }

    public function roomCategory()
    {
        return $this->belongsTo(RoomCategory::class);
    }
}
