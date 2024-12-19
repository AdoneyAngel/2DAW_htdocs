<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class productoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("productos")->insert([
            "nombre" => "Papas fritas",
            "descripcion" => "Papas",
            "categoria" => 1,
            "stock" => 3
        ]);
        DB::table("productos")->insert([
            "nombre" => "Mesa de madera",
            "descripcion" => "Mesa",
            "categoria" => 2,
            "stock" => 3
        ]);
        DB::table("productos")->insert([
            "nombre" => "Teléfono movil",
            "descripcion" => "Teléfono",
            "categoria" => 3,
            "stock" => 3
        ]);
    }
}
