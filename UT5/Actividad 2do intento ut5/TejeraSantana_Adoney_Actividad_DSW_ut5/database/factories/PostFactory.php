<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Post::class;

    public function definition(): array
    {
        return [
            "titulo" => $this->faker->realText(10),
            "cuerpo" => $this->faker->realText(20),
            "imagen" => $this->faker->imageUrl(),
            "usuario_id" => $this->faker->numberBetween(1, 10),
            "categoria_id" => $this->faker->numberBetween(1, 10)
        ];
    }
}
