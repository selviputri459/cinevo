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

    public function film()
    {
        return $this->belongsTo(Film::class);
    }

    public function studio()
    {
        return $this->belongsTo(Studio::class);
    }

    public function booking()
    {
        return $this->hasMany(Booking::class);
    }

    public function scopeUpcoming($query)
    {
        return $query->whereRaw("TIMESTAMP(`date`, `time`) >= ?", [now()->format('Y-m-d H:i:s')]);
    }

    public function scopePast($query)
    {
        return $query->whereRaw("TIMESTAMP(`date`, `time`) < ?", [now()->format('Y-m-d H:i:s')]);
    }
}
