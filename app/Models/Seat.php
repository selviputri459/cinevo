<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    use  HasFactory;

    protected $fillable = [
        'studio_id',
        'seat_name'
    ];

    public function studios()
    {
        return $this->belongsTo(Studio::class);
    }

    public function bookingDetails()
    {
        return $this->hasMany(BookingDetail::class);
    }
}
