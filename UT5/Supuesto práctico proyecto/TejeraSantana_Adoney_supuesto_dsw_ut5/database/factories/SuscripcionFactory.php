<?php

namespace Database\Factories;

use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Usuarios;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Suscripciones>
 */
class SuscripcionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_cliente' => $this->faker->numberBetween(2, 10),
            'tipo_suscripcion' => $this->faker->randomElement(['Diaria', 'Mensual', 'Anual']),
            'precio' => $this->faker->randomFloat(2, 20, 500),
            'dias' => $this->faker->numberBetween(1, 365),
            'fecha_fin' => $this->faker->date,
        ];
    }
}
