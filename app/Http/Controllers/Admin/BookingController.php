<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bookings = Booking::with(['user', 'film', 'showtime'])->latest()->paginate(10);
        return view('admin.booking.index', compact('bookings'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Booking $booking)
    {
        if (is_null($booking->seen_at)) {
            $booking->forceFill(['seen_at' => now()])->save();
        }
        return view('admin.booking.show', compact('booking'));
    }

    /**
     * Mark the booking as paid (Lunas).
     */
    public function markAsLunas(Booking $booking)
    {
        if (! in_array($booking->status, ['Menunggu Bayar', 'Menunggu Verifikasi'])) {
            return back()->withErrors(['status' => 'Status booking ini tidak bisa diubah ke Lunas.']);
        }

        $booking->update(['status' => 'Lunas']);
        return back()->with('success', 'Booking ditandai Lunas.');
    }

    /**
     * Cancel the booking.
     */
    public function cancel(Booking $booking)
    {
        if ($booking->status === 'Dibatalkan') {
            return back()->withErrors(['status' => 'Booking sudah dibatalkan.']);
        }

        $needsRefund = $booking->isTransfer()
            && in_array($booking->status, ['Lunas', 'Menunggu Verifikasi']);

        $booking->update([
            'status'        => 'Dibatalkan',
            'refund_status' => $needsRefund ? 'Menunggu Refund' : null,
        ]);
        $booking->update(['status' => 'Dibatalkan']);
        return redirect()->route('admin.booking.show', $booking)->with('success', 'Booking berhasil dibatalkan.');
        return back()->with('success', $needsRefund
            ? 'Booking dibatalkan. Jangan lupa kembalikan uang customer, lalu tandai refund.'
            : 'Booking dibatalkan.');
    }

    public function markAsRefunded(Booking $booking)
    {
        if ($booking->refund_status !== 'Menunggu Refund') {
            return back()->withErrors(['status' => 'Booking ini tidak sedang menunggu refund.']);
        }

        $booking->update(['refund_status' => 'Sudah Direfund']);
        return back()->with('success', 'Refund ditandai sudah dikirim.');
    }
}
