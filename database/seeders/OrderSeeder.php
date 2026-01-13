<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::factory()->count(5)->create();

    $users = \App\Models\User::all();

    \App\Models\Order::factory()
        ->count(10)
        ->state(fn () => ['user_id' => $users->random()->id])
        ->create();
    }
}
