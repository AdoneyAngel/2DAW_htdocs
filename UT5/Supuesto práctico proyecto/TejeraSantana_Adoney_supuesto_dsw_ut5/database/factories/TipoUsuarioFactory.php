<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TipoUsuario>
 */
class TipoUsuarioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tipo_usuario' => $this->faker->unique()->randomElement(["gestor", "entrenador", "cliente", "nutricionista"]),
            'descripcion' => $this->faker->sentence,
        ];
    }
}
