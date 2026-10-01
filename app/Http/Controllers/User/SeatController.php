<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BookingDetail;
use App\Models\Seat;
use App\Models\Showtime;
use App\Models\Studio;

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

        // jumlah kursi per blok (setengah baris), tetap untuk semua baris
        $seatsPerBlock = intdiv(Studio::SEATS_PER_ROW, 2);
 
        // kelompokkan per baris, lalu tiap baris dipecah jadi blok berukuran tetap
        $seatRows = $seatList->groupBy(function ($seat) {
                preg_match('/^([A-Za-z]+)/', $seat->seat_name, $match);
                return $match[1] ?? '?';
            })->map(function ($seatsInRow) use ($seatsPerBlock) {
                return $seatsInRow->values()->chunk($seatsPerBlock);
            });
 
        return view('user.seats.index', compact('showtime', 'seatRows', 'bookedSeatIds', 'seatsPerBlock'));
    }
}