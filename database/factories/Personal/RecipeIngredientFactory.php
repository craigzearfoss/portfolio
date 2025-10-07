<?php

namespace Database\Factories\Personal;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Personal\RecipeIngredient>
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
            'owner_id'      => \App\Models\Owner::all()->random()->id,
            'recipe_id'     => \App\Models\Personal\Recipe::all()->random()->id,
            'ingredient_id' => \App\Models\Personal\Ingredient::all()->random()->id,
            'amount'        => fake()->randomElement(['', '1/4', '1/2', '3/4', '1', '1 1/2', '2', '3', '4']),
            'unit_id'       => \App\Models\Personal\Unit::all()->random()->id,
            'qualifier'     => '',
            'created_at'    => now(),
            'deleted_at'    => now(),
        ];
    }
}
