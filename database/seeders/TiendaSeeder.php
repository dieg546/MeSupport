<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TiendaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tiendas = [
            [
                'nombre_tienda'   => 'Tienda Principal San Cristóbal',
                'codigo_sucursal' => 'SUC-001',
                'direccion'       => 'Av. 19 de Abril, CC Sambil, Nivel Feria, Local 12',
                'telefono'        => '0276-3531122',
                'created_at'      => now(),
                'updated_at'      => now(),
            ],
            [
                'nombre_tienda'   => 'Sucursal Barrio Obrero',
                'codigo_sucursal' => 'SUC-002',
                'direccion'       => 'Calle 14 entre Carreras 20 y 21, Edif. Centro, Local 3',
                'telefono'        => '0276-5128899',
                'created_at'      => now(),
                'updated_at'      => now(),
            ],
            [
                'nombre_tienda'   => 'Sucursal Caracas Chacao',
                'codigo_sucursal' => 'SUC-003',
                'direccion'       => 'Av. Francisco de Miranda, Centro Lido, Nivel Galería',
                'telefono'        => '0212-9514433',
                'created_at'      => now(),
                'updated_at'      => now(),
            ],
            [
                'nombre_tienda'   => 'Sucursal Valencia Sambil',
                'codigo_sucursal' => 'SUC-004',
                'direccion'       => 'Autopista del Este, CC Sambil Valencia, Nivel Autana',
                'telefono'        => '0241-8256677',
                'created_at'      => now(),
                'updated_at'      => now(),
            ],
            [
                'nombre_tienda'   => 'Sucursal Maracaibo Lago Mall',
                'codigo_sucursal' => 'SUC-005',
                'direccion'       => 'Av. El Milagro, CC Lago Mall, Nivel Plaza',
                'telefono'        => '0261-7921100',
                'created_at'      => now(),
                'updated_at'      => now(),
            ],
        ];

        DB::table('tiendas')->insert($tiendas);
    }
}