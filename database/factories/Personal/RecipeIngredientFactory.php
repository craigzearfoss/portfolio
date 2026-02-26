<?php

namespace Database\Factories\Personal;

use App\Models\Personal\Ingredient;
use App\Models\Personal\Recipe;
use App\Models\Personal\RecipeIngredient;
use App\Models\Personal\Unit;
use App\Models\System\Owner;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<RecipeIngredient>
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
            'owner_id'      => Owner::all()->random()->id,
            'recipe_id'     => Recipe::all()->random()->id,
            'ingredient_id' => Ingredient::all()->random()->id,
            'amount'        => fake()->randomElement(['', '1/4', '1/2', '3/4', '1', '1 1/2', '2', '3', '4']),
            'unit_id'       => Unit::all()->random()->id,
            'qualifier'     => '',
            'created_at'    => now(),
            'deleted_at'    => now(),
        ];
    }
}
