<?php

namespace Database\Factories;

use App\Models\Ejercicio;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Ejercicios;
use App\Models\EstadisticaEjercicio;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EstadisticasEjercicio>
 */
class EstadisticaEjercicioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = EstadisticaEjercicio::class;
    public function definition(): array
    {
        return [
            'id_ejercicio' => Ejercicio::factory(),
            'num_sesiones' => $this->faker->numberBetween(1, 30),
            'tiempo_total' => $this->faker->randomFloat(2, 10, 300),
            'duracion_media' => $this->faker->randomFloat(2, 1, 10),
            'sets_completados' => $this->faker->numberBetween(1, 50),
            'volumen_total' => $this->faker->randomFloat(2, 10, 1000),
            'repeticiones_totales' => $this->faker->numberBetween(10, 500),
            'fecha_entrenamiento' => $this->faker->date(),
        ];
    }
}

