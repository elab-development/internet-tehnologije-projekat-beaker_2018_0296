<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vehicle>
 */
class VehicleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "manufacturer"=>$this->faker->word(),
            "model"=>$this->faker->word(),
            "year"=>$this->faker->year(),
            "capacity"=>$this->faker->numberBetween(4,5),
            "rental_price"=>$this->faker->randomFloat(2,20,100),
            "available" => $this->faker->randomElement(['yes', 'no']),
        ];
    }
}
