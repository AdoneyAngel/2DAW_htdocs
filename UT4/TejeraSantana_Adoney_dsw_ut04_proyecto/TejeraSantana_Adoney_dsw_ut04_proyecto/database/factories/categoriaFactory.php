<?php

namespace Database\Factories;

use App\Models\Categoria;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Categoria>
 */
class CategoriaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Categoria::class;
    public function definition(): array
    {
        return [
            "nombre" => "categoria: ".$this->faker->unique()->company(),
            "descripcion" => $this->faker->realText(20)
        ];
    }
}
