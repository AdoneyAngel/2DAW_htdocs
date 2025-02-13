<?php

namespace Database\Factories;

use App\Models\PerfilUsuario;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Usuarios;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PerfilesUsuario>
 */
class PerfilUsuarioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = PerfilUsuario::class;
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->firstName,
            'apellido1' => $this->faker->lastName,
            'apellido2' => $this->faker->lastName,
            'edad' => $this->faker->numberBetween(13, 120),
            'direccion' => $this->faker->address,
            'telefono' => $this->faker->phoneNumber,
            'foto' => $this->faker->imageUrl(),
            'fecha_nacimiento' => $this->faker->date,
            'id_usuario' => $this->faker->numberBetween(2, 10),
        ];
    }
}
