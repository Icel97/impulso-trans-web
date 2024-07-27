<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class PagoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        foreach ($users as $user) {
            \App\Models\Pago::factory()->create([
                'comprobante_url' => 'C:\Users\sgale\Downloads\Pasaporte.pdf',
                'usuario_id' => $user->id,
            ]);
        }
    }
}
