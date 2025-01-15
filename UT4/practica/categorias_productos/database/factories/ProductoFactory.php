<?php

namespace Database\Factories;

use App\Models\Producto;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Producto>
 */
class ProductoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Producto::class;

    public function definition(): array
    {
        return [
            "nombre" => "prod__".$this->faker->company(),
            "descripcion" => $this->faker->realText(15),
            "stock" => $this->faker->numberBetween(1, 155),
            "categoria" => $this->faker->numberBetween(1, 5)
        ];
    }
}
