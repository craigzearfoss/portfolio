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
            'amount'        => fake()->numberBetween(1,4),
            'unit_id'       => \App\Models\Portfolio\Unit::all()->random()->id,
            'description'   => fake()->text(200),
            'image'         => fake()->imageUrl(),
            'image_credit'  => fake()->words(3, true),
            'image_source'  => fake()->words(3, true),
            'thumbnail'     => fake()->imageUrl(),
            'sequence'      => 0,
            'public'        => 1,
            'readonly'      => 0,
            'root'          => 0,
            'disabled'      => 0,
            'admin_id'      => \App\Models\Admin::all()->random()->id,
        ];
    }
}
