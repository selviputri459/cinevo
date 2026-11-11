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

    public function bookingChart(\Illuminate\Http\Request $request)
    {
        $period = $request->query('period', 'weekly');

        if ($period === 'monthly') {
            $jumlah = 12;
            $start  = now()->startOfMonth()->subMonths($jumlah - 1);
        } else {
            $period = 'weekly';
            $jumlah = 8;
            $start  = now()->startOfWeek()->subWeeks($jumlah - 1);
        }

        $bookings = \App\Models\Booking::where('created_at', '>=', $start)
            ->where('status', '!=', 'Dibatalkan')
            ->get(['created_at', 'status', 'total_price']);

        $labels       = [];
        $totalBooking = [];
        $pendapatan   = [];

        for ($i = 0; $i < $jumlah; $i++) {
            if ($period === 'monthly') {
                $from = $start->copy()->addMonths($i)->startOfMonth();
                $to   = $from->copy()->endOfMonth();
                $labels[] = $from->locale('id')->translatedFormat('M Y');
            } else {
                $from = $start->copy()->addWeeks($i);
                $to   = $from->copy()->endOfWeek();
                $labels[] = $from->format('d M') . ' - ' . $to->format('d M');
            }

            $dalamPeriode = $bookings->filter(fn ($b) => $b->created_at->between($from, $to));

            $totalBooking[] = $dalamPeriode->count();
            $pendapatan[]   = (int) $dalamPeriode->where('status', 'Lunas')->sum('total_price');
        }

        return response()->json(compact('labels', 'totalBooking', 'pendapatan'));
    }
}