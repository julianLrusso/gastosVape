<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoFacturaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tipo_gasto')->insert([
            'tipo' => 'Ingreso'
        ]);
        DB::table('tipo_gasto')->insert([
            'tipo' => 'Venta'
        ]);
    }
}
