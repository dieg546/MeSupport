<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModeloSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Helper para obtener ID de marca rápidamente
        $getMarcaId = fn($nombre) => DB::table('marcas')->where('nombre_marca', $nombre)->value('id_marca');

        // Helper para obtener ID de capacidad (memoria y ram)
        $getCapacidadId = fn($mem, $ram) => DB::table('capacidades')
            ->where('memoria', $mem)
            ->where('ram', $ram)
            ->value('id_capacidad');

        $modelos = [
            // Samsung
            [
                'id_marca'      => $getMarcaId('Samsung'),
                'id_capacidad'  => $getCapacidadId('256 GB', '8 GB'),
                'nombre_modelo' => 'Galaxy S26',
                'numero_serie'  => 'SN-SAM-S26-001',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'id_marca'      => $getMarcaId('Samsung'),
                'id_capacidad'  => $getCapacidadId('128 GB', '8 GB'),
                'nombre_modelo' => 'Galaxy A55',
                'numero_serie'  => 'SN-SAM-A55-002',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],

            // Xiaomi
            [
                'id_marca'      => $getMarcaId('Xiaomi'),
                'id_capacidad'  => $getCapacidadId('256 GB', '12 GB'),
                'nombre_modelo' => 'POCO X8 PRO',
                'numero_serie'  => 'SN-XIA-X8P-003',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'id_marca'      => $getMarcaId('Xiaomi'),
                'id_capacidad'  => $getCapacidadId('128 GB', '6 GB'),
                'nombre_modelo' => 'Redmi Note 15',
                'numero_serie'  => 'SN-XIA-N15-004',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],

            // Apple
            [
                'id_marca'      => $getMarcaId('Apple'),
                'id_capacidad'  => $getCapacidadId('256 GB', '8 GB'),
                'nombre_modelo' => 'iPhone 15 Pro',
                'numero_serie'  => 'SN-APP-15P-005',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'id_marca'      => $getMarcaId('Apple'),
                'id_capacidad'  => $getCapacidadId('128 GB', '6 GB'),
                'nombre_modelo' => 'iPhone 14',
                'numero_serie'  => 'SN-APP-140-006',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],

            // Infinix
            [
                'id_marca'      => $getMarcaId('Infinix'),
                'id_capacidad'  => $getCapacidadId('256 GB', '8 GB'),
                'nombre_modelo' => 'Note 40 Pro',
                'numero_serie'  => 'SN-INF-N40-007',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],

            // Tecno
            [
                'id_marca'      => $getMarcaId('Tecno'),
                'id_capacidad'  => $getCapacidadId('256 GB', '8 GB'),
                'nombre_modelo' => 'Camon 30',
                'numero_serie'  => 'SN-TEC-C30-008',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
        ];

        // Filtramos para asegurarnos de que no haya nulos si alguna relación no coincide
        $modelosValidos = array_filter($modelos, fn($item) => !is_null($item['id_marca']) && !is_null($item['id_capacidad']));

        DB::table('modelos')->insert($modelosValidos);
    }
}