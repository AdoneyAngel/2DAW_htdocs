<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cliente>
 */
class ClienteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "nombre" => $this->faker->name(),
            "tipo" => $this->faker->randomElement(["I", "E"]),
            "email" => $this->faker->email(),
            "direccion" => $this->faker->streetAddress(),
            "ciudad" => $this->faker->city(),
            "codigo_postal" => $this->faker->postcode()
        ];
    }
}
