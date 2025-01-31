<?php

namespace Database\Factories;

use App\Models\Ejercicio;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\TipoMusculo;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ejercicios>
 */
class EjercicioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Ejercicio::class;

    public function definition(): array
    {
        return [
            'nombre' => $this->faker->unique()->sentence(3),
            'id_tipo_musculo' => $this->faker->numberBetween(1, 10),
            'descripcion' => $this->faker->realText(15),
        ];
    }
}
