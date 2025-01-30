<?php

namespace Database\Factories;

use App\Models\EstadisticaCliente;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Usuarios;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EstadisticasCliente>
 */
class EstadisticaClienteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = EstadisticaCliente::class;
    public function definition(): array
    {
        return [
            'peso' => $this->faker->randomFloat(2, 40, 150),
            'altura' => $this->faker->randomFloat(2, 1.50, 2.20),
            'grasa_corporal' => $this->faker->randomFloat(2, 5, 30),
            'cintura' => $this->faker->randomFloat(2, 60, 120),
            'pecho' => $this->faker->randomFloat(2, 70, 150),
            'pierna' => $this->faker->randomFloat(2, 40, 80),
            'biceps' => $this->faker->randomFloat(2, 20, 50),
            'triceps' => $this->faker->randomFloat(2, 20, 50),
            'id_cliente' => $this->faker->numberBetween(2, 10),
        ];
    }
}
