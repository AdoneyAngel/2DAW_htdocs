<?php

namespace Database\Seeders;

use App\Models\PlanesNutricionales;
use App\Models\PlanNutricional;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlanesNutricionalesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PlanNutricional::factory()->count(10)->create();
    }
}
