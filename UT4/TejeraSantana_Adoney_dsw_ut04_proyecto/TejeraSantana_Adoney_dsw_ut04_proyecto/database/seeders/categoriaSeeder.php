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
        //Categorias por defecto
        $categorias = ["Comida", "Mueble", "Electrodoméstico", "Herramienta", "Videojuego", "Software"];

        foreach ($categorias as $categoria) {
            DB::table("categorias")->insert([
              "nombre" => $categoria,
              "descripcion" => "Descripcion de la categoria: $categoria"
            ]);
        }

        //Crear las categorias restantes
        Categoria::factory(1000-count($categorias))->create();
    }
}
