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

    public function activeBookings()
    {
        return $this->belongsToMany(Booking::class, 'booking_rooms')
            ->where('bookings.status', 'confirmed')
            ->where('bookings.check_out', '>', now());
    }

    public function getOccupiedBedsCountAttribute()
    {
        // One adult = one bed. Children usually don't count as a full "unit" in many systems,
        // but we'll track them separately and use adults for occupancy check.
        return $this->activeBookings()->sum('booking_rooms.adults');
    }

    public function getRemainingBedsAttribute()
    {
        return max(0, $this->roomCategory->capacity - $this->occupied_beds_count);
    }
}
