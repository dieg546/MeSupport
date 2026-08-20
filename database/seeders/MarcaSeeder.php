<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MarcaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $marcas = [
            ['nombre_marca' => 'Samsung', 'created_at' => now(), 'updated_at' => now()],
            ['nombre_marca' => 'Xiaomi', 'created_at' => now(), 'updated_at' => now()],
            ['nombre_marca' => 'Apple', 'created_at' => now(), 'updated_at' => now()],
            ['nombre_marca' => 'Motorola', 'created_at' => now(), 'updated_at' => now()],
            ['nombre_marca' => 'Infinix', 'created_at' => now(), 'updated_at' => now()],
            ['nombre_marca' => 'Tecno', 'created_at' => now(), 'updated_at' => now()],
            ['nombre_marca' => 'Realme', 'created_at' => now(), 'updated_at' => now()],
            ['nombre_marca' => 'Honor', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('marcas')->insert($marcas);
    }
}