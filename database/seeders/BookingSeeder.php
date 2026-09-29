<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Showtime;
use Illuminate\Database\Seeder;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Showtime::count() === 0) {
            $this->command->warn('Belum ada jadwal tayang, BookingSeeder dilewati. Jalankan ShowtimeSeeder dulu.');
            return;
        }

        Booking::factory()->count(5)->create();
    }
}