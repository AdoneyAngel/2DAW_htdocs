<?php

namespace Database\Factories;

use App\Models\Comentario;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ComentarioFactory extends Factory
{
    protected $model = Comentario::class;

    public function definition(): array
    {
        return [
            "Publicacion_ID" => $this->faker->numberBetween(1, 15),
            "Usuario_Comentario" => $this->faker->numberBetween(1, 10),
            "Texto_Comentario" => $this->faker->realText(15),
            "Fecha_Comentario" => $this->faker->dateTime()
        ];

    }
}
