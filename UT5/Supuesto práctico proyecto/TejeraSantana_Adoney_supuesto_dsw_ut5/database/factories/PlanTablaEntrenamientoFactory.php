<?php

namespace Database\Factories;

use App\Models\PlanEntrenamiento;
use App\Models\PlanTablaEntrenamiento;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\PlanesEntrenamiento;
use App\Models\TablaEntrenamiento;
use App\Models\TablasEntrenamiento;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PlanesTablaEntrenamiento>
 */
class PlanTablaEntrenamientoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = PlanTablaEntrenamiento::class;

    public function definition(): array
    {
        return [
            'id_plan' => PlanEntrenamiento::factory(),
            'id_tabla' => TablaEntrenamiento::factory(),
        ];
    }
}
