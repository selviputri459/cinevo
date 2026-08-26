<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\Seat;
use App\Models\BookingDetail;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<BookingDetail>
 */
class BookingDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Mengambil satu booking secara acak dari database
        $booking = Booking::inRandomOrder()->first();

        // Mengambil satu kursi secara acak dari database
        $seat = Seat::inRandomOrder()->first();

        return [
            // Menghubungkan detail booking dengan booking yang dipilih
            'booking_id' => $booking->id,

            // Menghubungkan detail booking dengan kursi yang dipilih
            'seat_id' => $seat->id,
        ];
    }
}
