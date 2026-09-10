<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Film;
use App\Models\Showtime;
use App\Models\Studio;

class DashboardController extends Controller
{
    public function index()
    {
        $totalFilm = Film::count();
        $totalJadwal = Showtime::count();
        $totalStudio = Studio::count();
        $totalBooking = Booking::count();

        $bookingTerbaru = Booking::with(['film', 'showtime.studio'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalFilm',
            'totalJadwal',
            'totalStudio',
            'totalBooking',
            'bookingTerbaru'
        ));
    }
}