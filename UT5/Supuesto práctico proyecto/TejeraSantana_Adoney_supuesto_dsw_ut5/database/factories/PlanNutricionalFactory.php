<?php

namespace Database\Factories;

use App\Models\PlanNutricional;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Usuarios;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PlanesNutricionales>
 */

class PlanNutricionalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = PlanNutricional::class;

    public function definition(): array
    {
        return [
            'id_nutricionista' => $this->faker->numberBetween(2, 10),
            'id_cliente' => $this->faker->numberBetween(2, 10),
            'nombre' => $this->faker->realText(10),
            'recomendaciones_dieta' => $this->faker->paragraph(),
            'porcentaje_carbohidratos' => $this->faker->randomFloat(2, 30, 70),
            'porcentaje_proteinas' => $this->faker->randomFloat(2, 1, 50),
            'porcentaje_grasas' => $this->faker->randomFloat(2, 1, 50),
            'porcentaje_fibra' => $this->faker->randomFloat(2, 5, 50),
            'fecha_inicio' => $this->faker->date(),
            'fecha_fin' => $this->faker->date()
        ];
    }
}
