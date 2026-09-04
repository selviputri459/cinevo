<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BookingDetail;
use App\Models\Seat;
use App\Models\Showtime;

class SeatController extends Controller
{
    public function index(Showtime $showtime)
    {
        $showtime->load(['film', 'studio']);
 
        // semua kursi milik studio dari showtime ini, diurutkan A1, A2, ... B1, B2, ...
        $seatList = Seat::where('studio_id', $showtime->studio_id)->get()->sortBy(function ($seat) {
                preg_match('/^([A-Za-z]+)(\d+)$/', $seat->seat_name, $match);
                return ($match[1] ?? '') . str_pad($match[2] ?? '0', 3, '0', STR_PAD_LEFT);
            });
 
        // kursi yang sudah dibooking untuk showtime ini (status masih aktif, bukan yang dibatalkan)
        $bookedSeatIds = BookingDetail::whereHas('booking', function ($query) use ($showtime) {
                $query->where('showtime_id', $showtime->id)
                      ->whereIn('status', ['Menunggu Bayar', 'Lunas']);
            })->pluck('seat_id')->toArray();
 
        // kelompokkan per baris (huruf depan seat_name), lalu tiap baris dipecah jadi 2 blok
        $seatRows = $seatList->groupBy(function ($seat) {
                preg_match('/^([A-Za-z]+)/', $seat->seat_name, $match);
                return $match[1] ?? '?';
            })->map(function ($seatsInRow) {
                return $seatsInRow->values()->chunk(ceil($seatsInRow->count() / 2));
            });
 
        return view('user.seats.index', compact('showtime', 'seatRows', 'bookedSeatIds'));
    }
}
