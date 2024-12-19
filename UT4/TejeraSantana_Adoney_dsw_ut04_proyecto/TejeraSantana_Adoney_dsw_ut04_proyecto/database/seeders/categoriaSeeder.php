<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class categoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categorias = ["Comida", "Mueble", "Electrodoméstico", "Herramienta", "Videojuego", "Software"];

        foreach ($categorias as $categoria) {
            DB::table("categorias")->insert([
              "nombre" => $categoria,
              "descripcion" => "Descripcion de la categoria: $categoria"
            ]);
        }
    }
}
