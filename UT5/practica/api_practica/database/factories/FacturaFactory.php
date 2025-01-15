<?php

namespace Database\Factories;

use App\Models\Cliente;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Factura>
 */
class FacturaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $estado = $this->faker->randomElement(["F", "P", "C", "A"]);
        return [
            "cliente_id" => Cliente::factory(),
            "cantidad" => $this->faker->numberBetween(100, 2000),
            "estado" => $estado,
            "fecha_creacion" => $this->faker->dateTimeThisDecade(),
            "fecha_pago" => $estado == "P" ? $this->faker->dateTimeThisDecade() : NULL
        ];
    }
}
