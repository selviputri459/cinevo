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
        $booking->load(['user', 'film', 'showtime.studio', 'bookingDetails.seat']);
        return view('admin.booking.show', compact('booking'));
    }

    /**
     * Mark the booking as paid (Lunas).
     */
    public function markAsLunas(Booking $booking)
    {
        $booking->update(['status' => 'Lunas']);
        return redirect()->route('admin.booking.show', $booking)->with('success', 'Booking berhasil ditandai Lunas.');
    }

    /**
     * Cancel the booking.
     */
    public function cancel(Booking $booking)
    {
        $booking->update(['status' => 'Dibatalkan']);
        return redirect()->route('admin.booking.show', $booking)->with('success', 'Booking berhasil dibatalkan.');
    }
}