<?php

namespace Database\Factories;

use App\Models\Showtime;
use App\Models\Film;
use App\Models\Studio;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Showtime>
 */
class ShowtimeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'film_id' => Film::factory(),
            'studio_id' => Studio::factory(),
            'date' => fake()->date(),
            'time'=> fake()->time(),
            'price' => fake()->randomElement([
                25000,
                30000,
                35000,
                40000,
                45000,
            ]),
        ];
    }
}
