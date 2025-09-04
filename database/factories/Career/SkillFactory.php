<?php

namespace Database\Factories\Career;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Career\Skills>
 */
class SkillFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'rating'       => fake()->numberBetween(1, 10),
            'years'        => fake()->numberBetween(0, 20),
            'description'  => fake()->text(200),
            'image'        => fake()->imageUrl(),
            'image_credit' => fake()->words(3, true),
            'image_source' => fake()->words(3, true),
            'thumbnail'    => fake()->imageUrl(),
            'sequence'     => 0,
            'public'       => 0,
            'readonly'     => 0,
            'root'         => 0,
            'disabled'     => fake()->numberBetween(0, 1),
            'admin_id'     => \App\Models\Admin::all()->random()->id,
        ];
    }
}
