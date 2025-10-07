<?php

namespace Database\Factories\Portfolio;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Personal\Recipe>
 */
class RecipeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->text(20);
        $slug = Str::slug($name);

        return [
            'owner_id'     => \App\Models\Owner::all()->random()->id,
            'name'         => $name,
            'slug'         => $slug,
            'featured'     => fake()->numberBetween(0, 1),
            'summary'      => fake()->text(200),
            'source'       => fake()->company(),
            'author'       => fake()->name(),
            'main'         => fake()->numberBetween(0, 1),
            'side'         => fake()->numberBetween(0, 1),
            'dessert'      => fake()->numberBetween(0, 1),
            'appetizer'    => fake()->numberBetween(0, 1),
            'beverage'     => fake()->numberBetween(0, 1),
            'breakfast'    => fake()->numberBetween(0, 1),
            'lunch'        => fake()->numberBetween(0, 1),
            'dinner'       => fake()->numberBetween(0, 1),
            'snack'        => fake()->numberBetween(0, 1),
            'link'         => fake()->url(),
            'link_name'    => fake()->text(20),
            'description'  => fake()->text(200),
            'image'        => fake()->imageUrl(),
            'image_credit' => fake()->name(),
            'image_source' => fake()->company(),
            'thumbnail'    => fake()->imageUrl(),
            'sequence'     => 0,
            'public'       => 1,
            'readonly'     => 0,
            'root'         => 0,
            'disabled'     => 0,
            'created_at'   => now(),
            'deleted_at'   => now(),
        ];
    }
}
