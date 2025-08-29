<?php

namespace Database\Factories\Portfolio;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Portfolio\Ingredient>
 */
class IngredientFactory extends Factory
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
            'link'        => fake()->url(),
            'description' => fake()->text(200),
            'image'       => fake()->imageUrl(),
            'thumbnail'   => fake()->imageUrl(),
            'sequence'    => 0,
            'public'      => fake()->numberBetween(0, 1),
            'readonly'    => fake()->numberBetween(0, 1),
            'root'        => fake()->numberBetween(0, 1),
            'disabled'    => fake()->numberBetween(0, 1),
        ];
    }
}
