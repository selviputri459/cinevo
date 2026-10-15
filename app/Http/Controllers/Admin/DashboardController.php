<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Film;
use App\Models\Showtime;
use App\Models\Studio;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $totalFilm = Film::count();
        $totalJadwal = Showtime::count();
        $totalStudio = Studio::count();
        $totalBooking = Booking::count();

        $filter = $request->get('filter') === 'baru' ? 'baru' : 'semua';

        $bookingTerbaru = Booking::with(['showtime.film', 'showtime.studio'])->latest();

        if ($filter === 'baru') {
            $bookingTerbaru->unseen();
        }

        $bookingTerbaru = $bookingTerbaru->take(5)->get();

        $totalBaru = Booking::unseen()->count();

        return view('admin.dashboard', compact(
            'totalFilm',
            'totalJadwal',
            'totalStudio',
            'totalBooking',
            'filter',
            'bookingTerbaru',
            'totalBaru'
        ));
    }
}