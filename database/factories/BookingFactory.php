<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Film;
use App\Models\Showtime;
use App\Models\Seat;
use App\Models\Booking;
use App\Models\BookingDetail;
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
            'booking_code' => 'CV' . strtoupper(fake()->unique()->bothify('####')),
            // Mengambil user secara otomatis dari UserFactory
            'user_id' => User::inRandomOrder()->value('id') ?? User::factory(),
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

    public function configure(): static 
    {
        return $this->afterCreating(function (Booking $booking) {
            $studioId = $booking->showtime->studio_id;

            $usedSeatIds = BookingDetail::whereHas('booking', function ($query) use ($booking) {
                $query->where('showtime_id', $booking->showtime_id) //mngmbl booking dg showtime yg sama
                ->where('id', '!=', $booking->id) //tdk mnghtng booking yg sdg dbwt
                ->where('status', '!=', 'Cancelled'); //booking yg batal tdk dianggap mgnkn krsi
            })->pluck('seat_id'); //mngmbl hnya id krsi dr bookingdetail tsb

             $availableSeats = Seat::where('studio_id', $studioId) //mcr krsi yg brd di studio yg sesuai
             ->whereNotIn('id', $usedSeatIds) // mnghndri krsi yg sdh dignkn olh booking lain
             ->inRandomOrder() // mngck urtn krsi agr pemilihannya tdk sllu sm
             ->take($booking->ticket_quantity) //mngbl krsi ssuai jmlh tkt yg dipesan
             ->get(); //mnjlnkn query dan mngmbl dta krsi

             foreach ($availableSeats as $seat) {
                BookingDetail::create([
                    'booking_id' => $booking->id,
                    'seat_id' => $seat->id
                ]);
             }
        });
    }
}
