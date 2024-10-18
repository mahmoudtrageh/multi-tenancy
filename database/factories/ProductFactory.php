<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
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
            'description' => fake()->name(),
            'slug' => fake()->name(),
            'unit_price' => 100,
            'category_id' => 1,
            'brand_id' => 1,
            'sub_category_id' => 1,
            'sub_sub_category_id' => 1,
            'current_stock' => 100,
            'product_type' => 'digital',
            'purchase_price' => 110
        ];
    }
}
