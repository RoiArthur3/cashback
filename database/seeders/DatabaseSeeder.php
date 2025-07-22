<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Compte admin par défaut
        User::factory()->create([
            'name' => 'Admin CabaCaba',
            'email' => 'admin@cbm.local',
            'password' => bcrypt('admin1234'),
            'role' => 'admin',
        ]);
    }
}
