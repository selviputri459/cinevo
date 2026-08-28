<?php

namespace Database\Factories;

use App\Models\Film;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Film>
 */
class FilmFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(3),
            'poster' => 'default-poster.jpg',
            'genre' => fake()->randomElement([
                'Action',
                'Comedy',
                'Drama',
                'Horror',
                'Animation',
            ]),
            'duration' => fake()->numberBetween(90, 180),
            'synopsis' => fake()->paragraph(),
        ];
    }
}
