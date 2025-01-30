<?php

namespace Database\Seeders;

use App\Models\PlanTablaEntrenamiento;
use Illuminate\Database\Seeder;
class PlanesTablaEntrenamientoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PlanTablaEntrenamiento::factory(10)->create();
    }
}
