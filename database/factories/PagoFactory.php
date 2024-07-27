<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pago>
 */
class PagoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'comprobante_url' => 'C:\Users\sgale\Downloads\Pasaporte.pdf',
            'usuario_id' => 1,
            'created_at' => $this->faker->dateTime(),	
        ];
    }
}
