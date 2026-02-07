<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingRoom extends Model
{
    protected $fillable = ['booking_id', 'room_id', 'tariff', 'deposit', 'adults', 'children', 'adults_male', 'adults_female'];
}
