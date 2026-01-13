<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceRequestFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'product_id' => Product::factory(),
            'phone' => fake()->phoneNumber(),
            'address' => fake()->word(),
            'preferred_date' => fake()->date(),
            'note' => fake()->text(),
            'status' => fake()->randomElement(['new', 'scheduled', 'done', 'cancelled']),
        ];
    }
}
