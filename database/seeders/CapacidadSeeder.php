<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CapacidadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $capacidades = [
            ['memoria' => '64 GB',  'ram' => '4 GB',  'created_at' => now(), 'updated_at' => now()],
            ['memoria' => '128 GB', 'ram' => '6 GB',  'created_at' => now(), 'updated_at' => now()],
            ['memoria' => '128 GB', 'ram' => '8 GB',  'created_at' => now(), 'updated_at' => now()],
            ['memoria' => '256 GB', 'ram' => '8 GB',  'created_at' => now(), 'updated_at' => now()],
            ['memoria' => '256 GB', 'ram' => '12 GB', 'created_at' => now(), 'updated_at' => now()],
            ['memoria' => '512 GB', 'ram' => '12 GB', 'created_at' => now(), 'updated_at' => now()],
            ['memoria' => '512 GB', 'ram' => '16 GB', 'created_at' => now(), 'updated_at' => now()],
            ['memoria' => '1 TB',   'ram' => '16 GB', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('capacidades')->insert($capacidades);
    }
}