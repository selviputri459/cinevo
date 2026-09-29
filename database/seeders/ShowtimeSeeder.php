<?php

namespace Database\Seeders;

use App\Models\Film;
use App\Models\Studio;
use App\Models\Showtime;
use Illuminate\Database\Seeder;

class ShowtimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Film::count() === 0) {
            $this->command->warn('Belum ada film, Showtime dilewati. Input film dulu lewat halaman admin.');
            return;
        }

        if (Studio::count() === 0) {
            $this->command->warn('Belum ada studio, Showtime dilewati.');
            return;
        }

        Showtime::factory()->count(20)->create();
    }
}