<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'brand' => fake()->word(),
            'btu' => fake()->numberBetween(-10000, 10000),
            'price' => fake()->numberBetween(-10000, 10000),
            'stock' => fake()->numberBetween(-10000, 10000),
            'description' => fake()->text(),
        ];
    }
}
