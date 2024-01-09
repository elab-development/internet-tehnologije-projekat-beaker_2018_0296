<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reservation>
 */
class ReservationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "pickup_date"=>$this->faker->dateTimeBetween('now','+30 days'),
           "return_date"=>$this->faker->dateTimeBetween('+31 days','+60 days'),
           "user_id"=>function() {
            return \App\Models\User::factory()->create()->id;
           },
           "vehicle_id"=>function() {
            return \App\Models\Vehicle::factory()->create()->id;
           },
        ];
    }
}
