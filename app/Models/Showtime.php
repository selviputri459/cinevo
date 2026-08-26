<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Showtime extends Model
{
    use HasFactory;

    protected $fillable = [
        'film_id',
        'studio_id',
        'date',
        'time',
        'price'
    ];

    public function films()
    {
        return $this->belongsTo(Film::class);
    }

    public function studios()
    {
        return $this->belongsTo(Studio::class);
    }

    public function booking()
    {
        return $this->hasMany(Booking::class);
    }
}
