<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_code',
        'user_id',
        'film_id',
        'showtime_id',
        'ticket_quantity',
        'total_price',
        'status'
    ];

    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function showtimes()
    {
        return $this->belongsTo(Showtime::class);
    }

    public function bookingDetails()
    {
        return $this->hasMany(BookingDetail::class);
    }
}
