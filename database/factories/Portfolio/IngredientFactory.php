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
            'admin_id' => \App\Models\Admin::all()->random()->id,
            'name'     => fake()->sentence(6),
            'slug'     => fake()->slug(6),
            'sequence' => 0,
            'public'   => fake()->numberBetween(0, 1),
            'disabled' => fake()->numberBetween(0, 1),
        ];
    }
}
