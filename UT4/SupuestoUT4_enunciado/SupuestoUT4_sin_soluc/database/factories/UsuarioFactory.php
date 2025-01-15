<?php

namespace Database\Factories;

use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsuarioFactory extends Factory
{

    protected $model = Usuario::class;

    public function definition(): array
    {
        return [
            "Nombre" => $this->faker->name(),
            "Nombre_Usuario" => $this->faker->name(),
            "Correo_Electronico" => $this->faker->email(),
            "Contraseña" => $this->faker->password(),
            "Fecha_Registro" => $this->faker->dateTime(),
            "Foto_Perfil" => $this->faker->randomLetter(5)
        ];
    }
}
