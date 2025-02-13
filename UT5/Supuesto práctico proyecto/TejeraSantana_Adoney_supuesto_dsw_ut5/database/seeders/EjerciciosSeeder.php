<?php

namespace Database\Seeders;

use App\Models\Ejercicio;
use App\Models\Ejercicios;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EjerciciosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Ejercicio::factory()->count(10)->create();
    }
}
