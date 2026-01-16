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
    $products = [
        ['name' => 'Samsung WindFree 12', 'brand' => 'Samsung', 'btu' => 12000, 'price' => 89990],
        ['name' => 'Samsung WindFree 18', 'brand' => 'Samsung', 'btu' => 18000, 'price' => 124990],
        ['name' => 'Gree Fairy 12', 'brand' => 'Gree', 'btu' => 12000, 'price' => 67990],
        ['name' => 'Gree Amber Nordic 18', 'brand' => 'Gree', 'btu' => 18000, 'price' => 109990],
        ['name' => 'LG Dual Inverter 12', 'brand' => 'LG', 'btu' => 12000, 'price' => 79990],
        ['name' => 'Daikin Sensira 12', 'brand' => 'Daikin', 'btu' => 12000, 'price' => 99990],
        ['name' => 'Midea Mission Pro 12', 'brand' => 'Midea', 'btu' => 12000, 'price' => 64990],
        ['name' => 'Fujitsu KMTA 12', 'brand' => 'Fujitsu', 'btu' => 12000, 'price' => 114990],
    ];

    $pick = $this->faker->randomElement($products);

    return [
        'name' => $pick['name'],
        'brand' => $pick['brand'],
        'btu' => $pick['btu'],
        'price' => $pick['price'],
        'stock' => $this->faker->numberBetween(0, 25),
        'description' => $this->faker->sentence(12),
    ];
}


}
