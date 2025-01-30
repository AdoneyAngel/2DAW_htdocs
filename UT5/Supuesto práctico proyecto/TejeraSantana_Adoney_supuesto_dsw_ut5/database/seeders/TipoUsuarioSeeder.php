<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TipoUsuario;
use Illuminate\Support\Facades\DB;

class TipoUsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Crear los tipos de usuarios por defecto
        DB::table("tipousuario")->insert([
            "tipo_usuario" => "administrador",
            "descripcion" => "El administrador"
        ]);

        TipoUsuario::factory(4)->create();
    }
}
