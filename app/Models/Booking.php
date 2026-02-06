<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = ['guest_id', 'check_in', 'check_out', 'total_amount', 'paid_amount', 'status', 'payment_mode'];

    protected $casts = [
        'check_in' => 'datetime',
        'check_out' => 'datetime',
        'total_amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
    ];

    public function guest()
    {
        return $this->belongsTo(Guest::class);
    }

    public function rooms()
    {
        return $this->belongsToMany(Room::class, 'booking_rooms')->withPivot('tariff', 'deposit');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
