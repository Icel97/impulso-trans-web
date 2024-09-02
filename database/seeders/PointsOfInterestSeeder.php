<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PointOfInterest;

class PointsOfInterestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PointOfInterest::create([
            'estado' => 'Ciudad de México',
            'lat' => 19.432608,
            'lng' => -99.133209,
            'documentos' => 'Acta de nacimiento, Identificación oficial, Comprobante de domicilio',
        ]);
    }
}
