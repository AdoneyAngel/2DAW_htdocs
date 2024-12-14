<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermisoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permisos = ["Edición", "Escritura", "Lectura", "Eliminación"];

        foreach ($permisos as $index => $permiso) {
            DB::table("permisos")->insert([
                "nombre" =>$permiso,
                "id"=>$index+1
            ]);
        }
    }
}
