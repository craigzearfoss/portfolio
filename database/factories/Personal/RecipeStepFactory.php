<?php

namespace Database\Factories\Personal;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Personal\RecipeStep>
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
            'owner_id'    => \App\Models\Owner::all()->random()->id,
            'recipe_id'   => \App\Models\Personal\Recipe::all()->random()->id,
            'step'        => fake()->numberBetween(1, 8),
            'description' => fake()->text(200),
            'created_at'  => now(),
            'deleted_at'  => now(),
        ];
    }
}
