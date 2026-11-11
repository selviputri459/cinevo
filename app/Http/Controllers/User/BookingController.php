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
     * 
     */
    public function index(Request $request)
    {
        $status = $request->query('status', 'semua');

        $statusMap = [
            'selesai'    => ['Lunas'],
            'menunggu'   => ['Menunggu Bayar', 'Menunggu Verifikasi'],
            'dibatalkan' => ['Dibatalkan'],
        ];
        $bookings = Booking::with(['showtime.film', 'showtime.studio'])
            ->where('user_id', auth()->id())
            ->when(isset($statusMap[$status]), function ($query) use ($statusMap, $status) {
                $query->whereIn('status', $statusMap[$status]);
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
        $user = auth()->user();

        if (empty($user->phone)) {
            $request->validate([
                'phone' => ['required', 'regex:/^(08|628)[0-9]{8,12}$/', 'unique:users,phone'],
            ], [
                'phone.required' => 'No. telepon wajib diisi sebelum booking tiket.',
                'phone.regex'    => 'Format no. telepon tidak valid (contoh: 08123456789).',
                'phone.unique'   => 'No. telepon ini sudah dipakai akun lain.',
            ]);

            $user->update(['phone' => $request->phone]);
        }

        $validated = $request->validate([
            'showtime_id' => ['required', 'exists:showtimes,id'],
            'seat_id' => ['required', 'array', 'min:1'],
            'seat_id.*' => ['exists:seats,id'],
            'payment_method'  => ['required', 'in:cash,transfer'],
            'payment_channel' => ['required_if:payment_method,transfer', 'nullable', 'in:Mandiri,BNI,DANA'],
            'sender_account'  => ['required_if:payment_method,transfer', 'nullable', 'string', 'max:100'],
            'payment_proof'   => ['required_if:payment_method,transfer', 'nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);

        $showtime = Showtime::findOrFail($validated['showtime_id']);
        $seatIds = $validated['seat_id'];

        if ($this->seatsAlreadyBooked($showtime, collect($seatIds))) {
            return redirect()
                ->route('seats.index', $showtime)
                ->withErrors(['seat_id' => 'Ada kursi yang baru saja dibooking orang lain, silakan pilih ulang.']);
        }

       $isTransfer = $validated['payment_method'] === 'transfer';

        $proofPath = $isTransfer
            ? $request->file('payment_proof')->store('payment-proofs', 'public')
            : null;

        $booking = DB::transaction(function () use ($showtime, $seatIds, $validated, $isTransfer, $proofPath) {
            $booking = Booking::create([
                'booking_code' => 'BK-' . strtoupper(Str::random(8)),
                'user_id' => auth()->id(),
                'film_id' => $showtime->film_id,
                'showtime_id' => $showtime->id,
                'ticket_quantity' => count($seatIds),
                'total_price' => count($seatIds) * $showtime->price,
                'status' => $isTransfer ? 'Menunggu Verifikasi' : 'Menunggu Bayar',
                'payment_method'  => $validated['payment_method'],
                'payment_channel' => $isTransfer ? $validated['payment_channel'] : null,
                'sender_account'  => $isTransfer ? $validated['sender_account'] : null,
                'payment_proof'   => $proofPath,
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

        if ($booking->status !== 'Menunggu Bayar' || $booking->isTransfer()) {
            return back()->withErrors(['status' => 'Booking ini tidak bisa dibatalkan sendiri. Hubungi admin lewat WhatsApp.']);
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
                $query->where('showtime_id', $showtime->id)->whereIn('status', ['Menunggu Bayar', 'Menunggu Verifikasi', 'Lunas']);
            })->whereIn('seat_id', $seatIds)->exists();
    }

    public function ticket(Booking $booking)
    {
        abort_if($booking->user_id !== auth()->id(), 403);
        abort_unless($booking->isTransfer(), 404);

        $booking->load(['user', 'showtime.film', 'showtime.studio', 'bookingDetails.seat']);

        return view('user.bookings.ticket', compact('booking'));
    }
}