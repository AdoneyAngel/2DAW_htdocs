<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\categoria>
 */
class categoriaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "nombre" => $this->faker->unique()->randomElement(["Comida", "Mueble", "Electrodoméstico", "Herramienta", "Videojuego", "Software"]),
            "descripcion" => $this->faker->realText(50)
        ];
    }
}
