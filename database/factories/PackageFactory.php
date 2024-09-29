<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Package>
 */
class PackageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'annual_price' => fake()->randomFloat(2, 1, 1000),
            'monthly_price' => fake()->randomFloat(2, 1, 1000),
            'trial_period' => 15
        ];
    }
}
