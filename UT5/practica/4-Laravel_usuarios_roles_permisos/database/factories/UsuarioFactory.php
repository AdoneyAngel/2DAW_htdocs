<?php

namespace Database\Factories;

use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Usuario>
 */
class UsuarioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Usuario::class;

    public function definition(): array
    {
        return [
            "nombre" => $this->faker->firstName(),
            "apellidos" => $this->faker->lastName(),
            "usuario" => $this->faker->firstName(),
            "password" => $this->faker->password(),
            "email" => $this->faker->email()
        ];
    }
}
