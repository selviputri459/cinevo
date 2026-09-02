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
            'film_id' => Film::inRandomOrder()->value('id'), 
            'studio_id' => Studio::inRandomOrder()->value('id'), 
            'date' => now()->addDays(rand(0, 6))->toDateString(), 
            'time'=> fake()->randomElement([ 
                '10:00', 
                '13:00', 
                '16:00', 
                '19:00', 
                '21:30' 
            ]), 
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