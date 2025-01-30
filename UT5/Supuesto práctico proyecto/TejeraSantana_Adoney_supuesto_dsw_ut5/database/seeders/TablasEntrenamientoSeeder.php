<?php

namespace Database\Seeders;

use App\Models\TablaEntrenamiento;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TablasEntrenamiento;
class TablasEntrenamientoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TablaEntrenamiento::factory()->count(10)->create();
    }
}
