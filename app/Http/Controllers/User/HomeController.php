<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Film;
use Illuminate\Support\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        $today = Carbon::today()->toDateString();

        // Film yang punya jadwal tayang (hari ini/ke depan) => sudah bisa dibooking
        $sedangTayang = Film::whereHas('showtimes', function ($query) use ($today) {
                $query->where('date', '>=', $today);
            })
            ->with(['showtimes' => function ($query) use ($today) {
                $query->where('date', '>=', $today)->orderBy('price');
            }])->latest()->get();

        // Film yang belum punya jadwal tayang sama sekali => baru preview
        $segeraTayang = Film::whereDoesntHave('showtimes')->latest()->get();

        return view('user.home.index', compact('sedangTayang', 'segeraTayang'));
    }
}