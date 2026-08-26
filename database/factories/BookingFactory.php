<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Film;
use App\Models\Showtime;
use App\Models\Booking;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Booking>
 */
class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Mengambil satu data showtime secara acak dari database
        $showtime = Showtime::inRandomOrder()->first();

        // Menentukan jumlah tiket secara acak, antara 1 sampai 5 tiket
        $ticketQuantity = fake()->numberBetween(1, 5);

        return [
            // Membuat kode booking yang unik, contoh: CINEVO-AB1234
            'booking_code' => 'CINEVO-' . strtoupper(fake()->unique()->bothify('??####')),
            // Mengambil user secara otomatis dari UserFactory
            'user_id' => User::factory(),
            // Mengambil film yang sesuai dengan showtime yang dipilih
            'film_id' => $showtime->film_id,
            // Mengambil ID showtime yang dipilih secara acak
            'showtime_id' => $showtime->id,
            // Menentukan jumlah tiket yang dibeli
            'ticket_quantity' => $ticketQuantity,
            // Menghitung total harga berdasarkan harga tiket × jumlah tiket
            'total_price' => $showtime->price * $ticketQuantity,
            // Menentukan status booking secara acak
            'status' => fake()->randomElement([
                'pending',
                'confirmed',
                'cancelled',
            ]),
        ];
    }
}
