<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TablaEntrenamientoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'semana' => $this->faker->numberBetween(1, 3),
            'nombre' => $this->faker->sentence(2),
            'num_ejercicios' => $this->faker->numberBetween(1, 3),
            'num_dias' => $this->faker->numberBetween(1, 5),
            'num_series' => $this->faker->numberBetween(1, 10),
        ];
    }
}
