<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@gmail.com',
            'password' => bcrypt('12341234'),
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Test User2',
            'email' => 'test2@gmail.com',
            'password' => bcrypt('12341234'),
        ]);

    }
}
