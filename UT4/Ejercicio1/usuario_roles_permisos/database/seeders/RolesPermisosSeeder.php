<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesPermisosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Permisos de administrador
        DB::table("roles_permisos")->insert([
            "id"=>1,
            "id_rol"=>1,
            "id_permiso"=>1
        ]);
        DB::table("roles_permisos")->insert([
            "id"=>2,
            "id_rol"=>1,
            "id_permiso"=>2
        ]);
        DB::table("roles_permisos")->insert([
            "id"=>3,
            "id_rol"=>1,
            "id_permiso"=>3
        ]);
        DB::table("roles_permisos")->insert([
            "id"=>4,
            "id_rol"=>1,
            "id_permiso"=>4
        ]);
    }
}
