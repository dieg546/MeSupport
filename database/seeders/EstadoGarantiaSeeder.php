<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstadoGarantiaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $estados = [
            ['id_estado' => 1, 'nombre_estado' => 'Abierta', 'created_at' => now(), 'updated_at' => now()],
            ['id_estado' => 2, 'nombre_estado' => 'En Revision', 'created_at' => now(), 'updated_at' => now()],
            ['id_estado' => 3, 'nombre_estado' => 'Finalizada', 'created_at' => now(), 'updated_at' => now()],
            ['id_estado' => 4, 'nombre_estado' => 'Rechazada', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('estados_garantias')->upsert(
            $estados,
            ['id_estado'],
            ['nombre_estado', 'updated_at']
        );
    }
}