<?php

namespace Database\Seeders;

use App\Models\Rol;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Nette\Utils\Random;

class RolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = ["Cliente", "Gestor", "Administrador"];

        foreach ($roles as $rol) {
            DB::table("roles")->insert([
                "nombre" =>$rol
            ]);
        }
    }
}
