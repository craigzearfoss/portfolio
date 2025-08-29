<?php

namespace Database\Factories\Portfolio;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Portfolio\RecipeIngredient>
 */
class RecipeIngredientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'        => fake()->unique()->word(1),
            'slug'        => fake()->unique()->slug(1),
            'description' => fake()->text(200),
            'image'       => fake()->imageUrl(),
            'thumbnail'   => fake()->imageUrl(),
        ];
    }
}
