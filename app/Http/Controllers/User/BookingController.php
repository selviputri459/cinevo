<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingDetail;
use App\Models\Seat;
use App\Models\Showtime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    /**
     * Halaman "Riwayat Booking" - daftar semua booking milik user, bisa difilter per tab.
     */
    public function index(Request $request)
    {
        $status = $request->query('status', 'semua');

        $statusMap = [
            'selesai' => 'Lunas',
            'menunggu' => 'Menunggu Bayar',
            'dibatalkan' => 'Dibatalkan',
        ];

        $bookings = Booking::with(['showtime.film', 'showtime.studio'])
            ->where('user_id', auth()->id())
            ->when(isset($statusMap[$status]), function ($query) use ($statusMap, $status) {
                $query->where('status', $statusMap[$status]);
            })->latest()->get();

        return view('user.bookings.index', compact('bookings', 'status'));
    }

    /**
     * Halaman "Booking Tiket" - review sebelum booking disimpan.
     */
    public function create(Request $request)
    {
        $validated = $request->validate([
            'showtime_id' => ['required', 'exists:showtimes,id'],
            'seat_id' => ['required', 'array', 'min:1'],
            'seat_id.*' => ['exists:seats,id'],
        ]);

        $showtime = Showtime::with(['film', 'studio'])->findOrFail($validated['showtime_id']);
        $seats = Seat::whereIn('id', $validated['seat_id'])->orderBy('seat_name')->get();

        if ($this->seatsAlreadyBooked($showtime, $seats->pluck('id'))) {
            return redirect()->route('seats.index', $showtime)
                ->withErrors(['seat_id' => 'Ada kursi yang baru saja dibooking orang lain, silakan pilih ulang.']);
        }

        $total = $seats->count() * $showtime->price;

        return view('user.bookings.create', compact('showtime', 'seats', 'total'));
    }

    /**
     * Simpan booking + detail kursinya.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'showtime_id' => ['required', 'exists:showtimes,id'],
            'seat_id' => ['required', 'array', 'min:1'],
            'seat_id.*' => ['exists:seats,id'],
        ]);

        $showtime = Showtime::findOrFail($validated['showtime_id']);
        $seatIds = $validated['seat_id'];

        if ($this->seatsAlreadyBooked($showtime, collect($seatIds))) {
            return redirect()
                ->route('seats.index', $showtime)
                ->withErrors(['seat_id' => 'Ada kursi yang baru saja dibooking orang lain, silakan pilih ulang.']);
        }

        $booking = DB::transaction(function () use ($showtime, $seatIds) {
            $booking = Booking::create([
                'booking_code' => 'BK-' . strtoupper(Str::random(8)),
                'user_id' => auth()->id(),
                'film_id' => $showtime->film_id,
                'showtime_id' => $showtime->id,
                'ticket_quantity' => count($seatIds),
                'total_price' => count($seatIds) * $showtime->price,
                'status' => 'Menunggu Bayar',
            ]);

            foreach ($seatIds as $seatId) {
                $booking->bookingDetails()->create(['seat_id' => $seatId]);
            }

            return $booking;
        });

        return redirect()->route('booking.show', $booking);
    }

    /**
     * Halaman "Detail Booking".
     */
    public function show(Booking $booking)
    {
        abort_if($booking->user_id !== auth()->id(), 403);

        $booking->load(['showtime.film', 'showtime.studio', 'bookingDetails.seat']);

        return view('user.bookings.show', compact('booking'));
    }

    /**
     * Batalkan booking (cuma boleh kalau masih Menunggu Bayar).
     */
    public function cancel(Booking $booking)
    {
        abort_if($booking->user_id !== auth()->id(), 403);

        if ($booking->status !== 'Menunggu Bayar') {
            return back()->withErrors(['status' => 'Booking ini sudah tidak bisa dibatalkan.']);
        }

        $booking->update(['status' => 'Dibatalkan']);

        return redirect()->route('booking.show', $booking)->with('success', 'Booking berhasil dibatalkan.');
    }

    /**
     * Cek apakah salah satu dari kursi yang dipilih sudah kepakai
     * di showtime ini (status booking-nya masih aktif).
     */
    private function seatsAlreadyBooked(Showtime $showtime, $seatIds): bool
    {
        return BookingDetail::whereHas('booking', function ($query) use ($showtime) {
                $query->where('showtime_id', $showtime->id)
                      ->whereIn('status', ['Menunggu Bayar', 'Lunas']);
            })->whereIn('seat_id', $seatIds)->exists();
    }
}