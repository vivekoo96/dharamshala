<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    protected $fillable = ['first_name', 'last_name', 'mobile_number', 'id_type', 'id_number', 'id_image_path', 'address'];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
