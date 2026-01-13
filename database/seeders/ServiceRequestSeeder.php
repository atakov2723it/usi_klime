<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ServiceRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = \App\Models\User::all();
        if ($users->isEmpty()) {
            \App\Models\User::factory()->count(5)->create();
            $users = \App\Models\User::all();
        }

        \App\Models\ServiceRequest::factory()
            ->count(10)
            ->state(fn () => ['user_id' => $users->random()->id])
            ->create();
    }
}
