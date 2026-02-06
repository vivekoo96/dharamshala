<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomCategory extends Model
{
    protected $fillable = ['name', 'base_tariff', 'deposit', 'capacity', 'features'];

    protected $casts = [
        'features' => 'array',
        'base_tariff' => 'decimal:2',
        'deposit' => 'decimal:2',
    ];

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }
}
