<?php

namespace Database\Factories;

use App\Models\PlanEntrenamiento;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Usuarios;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PlanesEntrenamiento>
 */
class PlanEntrenamientoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = PlanEntrenamiento::class;
    public function definition(): array
    {
        return [
            'id_entrenador' => $this->faker->numberBetween(2, 10),
            'id_cliente' => $this->faker->numberBetween(2, 10),
            'nombre' => $this->faker->sentence(3),
            'fecha_inicio' => $this->faker->optional()->date,
            'fecha_fin' => $this->faker->optional()->date,
        ];
    }
}
