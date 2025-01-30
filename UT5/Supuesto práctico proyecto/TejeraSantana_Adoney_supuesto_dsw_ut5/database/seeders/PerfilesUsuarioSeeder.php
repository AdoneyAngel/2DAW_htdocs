<?php

namespace Database\Seeders;

use App\Models\PerfilesUsuario;
use App\Models\PerfilUsuario;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PerfilesUsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PerfilUsuario::factory()->count(10)->create();
    }
}
