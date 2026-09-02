<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Film;
use Illuminate\Http\Request;
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

    public function jadwal(Film $film, Request $request)
    {
        $today = Carbon::today()->toDateString();
        $film->load(['showtimes' => function ($query) use ($today) {
            $query->where('date', '>=', $today)->orderBy('date')->orderBy('time');
        }, 'showtimes.studio']);
        $dates = $film->showtimes->pluck('date')->unique()->values();
        $selectedDate = $request->query('date', $dates->first());
        $showtimesByStudio = $film->showtimes->where('date', $selectedDate)->groupBy('studio_id');

        return view('user.film.jadwal', compact('film', 'dates', 'selectedDate', 'showtimesByStudio'));

    }
}