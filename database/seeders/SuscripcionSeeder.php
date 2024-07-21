<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class SuscripcionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();


        foreach ($users as $user) {
            \App\Models\Suscripcion::factory()->create([
                'estatus' => 'Inactiva',
                'usuario_id' => $user->id,
            ]);
        } 

    }
}
