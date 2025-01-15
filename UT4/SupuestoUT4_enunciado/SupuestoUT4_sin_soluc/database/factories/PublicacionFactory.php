<?php

namespace Database\Factories;

use App\Models\Publicacion;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PublicacionFactory extends Factory
{
    protected $model = Publicacion::class;

    public function definition(): array
    {
        return [
            "Usuario_ID" => $this->faker->numberBetween(1, 10),
            "Nombre" => $this->faker->realText(20),
            "Descripcion" => $this->faker->realText(100),
            "Fecha_Publicacion" => $this->faker->dateTime(),
            "URL_Archivo" => $this->faker->realText(10)."txt"
        ];
    }
}
