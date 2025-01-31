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
            'peso' => $this->faker->randomFloat(2, 30, 100),
            'triceps' => $this->faker->randomFloat(2, 10, 100),
            'altura' => $this->faker->randomFloat(2, 1.0, 4.50),
            'pecho' => $this->faker->randomFloat(2, 10, 200),
            'pierna' => $this->faker->randomFloat(2, 20, 100),
            'grasa_corporal' => $this->faker->randomFloat(2, 1, 50),
            'cintura' => $this->faker->randomFloat(2, 30, 150),
            'biceps' => $this->faker->randomFloat(2, 5, 70),
            'id_cliente' => $this->faker->numberBetween(2, 10),
        ];
    }
}
