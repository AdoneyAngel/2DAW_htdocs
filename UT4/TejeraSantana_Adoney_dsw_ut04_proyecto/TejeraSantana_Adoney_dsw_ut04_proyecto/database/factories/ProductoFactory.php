<?php

namespace Database\Factories;

use App\Models\Producto;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
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
            "nombre" => "producto: ".$this->faker->unique()->city(),
            "descripcion" => $this->faker->realText(15),
            "stock" => $this->faker->randomNumber(2),
            "categoria" => $this->faker->unique()->numberBetween(4, 1000)
        ];
    }
}
