<?php

namespace Database\Seeders;

use App\Models\Material;
use App\Models\Volqueta;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VolquetasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        // Volqueta::create([
        //     'placa' => "KAA-1311",
        //     'propietario' => 'SHIGAVITRANS',
        //     'conductor' => 'ELEODORO GUADALUPE',
        //     'cubicaje' => 10.16
        // ]);

        Material::create([
            'nombre' => 'ZARANDEADO 3',
        ]);

    }
}
