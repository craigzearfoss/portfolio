<?php

namespace Database\Factories\Portfolio;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Portfolio\RecipeStep>
 */
class RecipeStepFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'recipe_id'   => \App\Models\Portfolio\Recipe::all()->random()->id,
            'step'        => fake()->numberBetween(1, 8),
            'description' => fake()->text(200),
            'admin_id'    => \App\Models\Admin::all()->random()->id,
        ];
    }
}
