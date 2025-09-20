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
            'recipe_id'     => \App\Models\Portfolio\Recipe::all()->random()->id,
            'ingredient_id' => \App\Models\Portfolio\Ingredient::all()->random()->id,
            'amount'        => fake()->randomElement(['', '1/4', '1/2', '3/4', '1', '1 1/2', '2', '3', '4']),
            'unit_id'       => \App\Models\Portfolio\Unit::all()->random()->id,
            'qualifier'     => '',
            'admin_id'      => \App\Models\Admin::all()->random()->id,
        ];
    }
}
