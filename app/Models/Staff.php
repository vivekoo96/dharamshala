<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $fillable = [
        'name',
        'role',
        'phone',
        'email',
        'qr_code',
        'status',
    ];

    public function attendance()
    {
        return $this->hasMany(Attendance::class);
    }
}
