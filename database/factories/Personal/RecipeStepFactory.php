<?php

namespace Database\Factories\Personal;

use App\Models\Personal\Recipe;
use App\Models\Personal\RecipeStep;
use App\Models\System\Owner;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<RecipeStep>
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
            'owner_id'    => Owner::all()->random()->id,
            'recipe_id'   => Recipe::all()->random()->id,
            'step'        => fake()->numberBetween(1, 8),
            'description' => fake()->text(),
            'created_at'  => now(),
            'deleted_at'  => now(),
        ];
    }
}
