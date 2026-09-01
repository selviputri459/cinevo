<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Film;
use Illuminate\Support\Carbon;

class FilmController extends Controller
{
    public function show(Film $film)
    {
        $today = Carbon::today()->toDateString();

        $film->load(['showtimes' => function ($query) use ($today) {
            $query->where('date', '>=', $today)
                ->orderBy('date')
                ->orderBy('time');
        }, 'showtimes.studio']);

        return view('user.film.show', compact('film'));
    }
}