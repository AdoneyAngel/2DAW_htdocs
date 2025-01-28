<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Insertar usuarios por defecto

        // //Usuarios
        // DB::table("usuarios") ->insert([
        //     "nombre" => "Administrador",
        //     "apellidos" => "El admin de la actividad",
        //     "email" => "admin@gmail.com"
        // ]);

        // DB::table("usuarios")->insert([
        //     "nombre" => "Actualizador",
        //     "apellidos" => "Parcheador",
        //     "email" => "actualizador@gmail.com"
        // ]);

        // DB::table("usuarios")->insert([
        //     "nombre" => "Visor",
        //     "apellidos" => "Espectador",
        //     "email" => "visor@gmail.com"
        // ]);



        // //Categorias
        // DB::table("categorias")->insert([
        //     "nombre" => "Deportes",
        //     "descripcion" => "Algo de deporte"
        // ]);

        // DB::table("categorias")->insert([
        //     "nombre" => "Politica",
        //     "descripcion" => "Gobierno"
        // ]);

        // DB::table("categorias")->insert([
        //     "nombre" => "Tecnología",
        //     "descripcion" => "ChatGPT"
        // ]);
    }
}
