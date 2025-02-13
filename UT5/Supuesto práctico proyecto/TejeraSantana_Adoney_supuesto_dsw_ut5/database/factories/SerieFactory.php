<?php

namespace Database\Factories;

use App\Models\Ejercicio;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Ejercicios;
use App\Models\Serie;
use App\Models\TablaEntrenamiento;
use App\Models\TablasEntrenamiento;
use App\Models\TipoSerie;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Series>
 */
class SerieFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Serie::class;

    public function definition(): array
    {
        return [
            'repeticiones_min' => $this->faker->numberBetween(5, 100),
            'repeticiones_max' => $this->faker->numberBetween(10, 200),
            'peso' => $this->faker->randomFloat(2, 5, 200),
            'duracion' => $this->faker->randomFloat(2, 5, 240),
            'descanso' => $this->faker->randomFloat(2, 5, 90),
            'id_ejercicio' => $this->faker->numberBetween(1, 10),
            'id_tabla' => $this->faker->numberBetween(1, 10),
            'id_tipo_serie' => $this->faker->numberBetween(1, 10),
        ];
    }
}
