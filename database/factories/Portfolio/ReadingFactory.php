<?php

namespace Database\Factories\Portfolio;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Portfolio\Reading>
 */
class ReadingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title'     => fake()->sentence(6),
            'author'    => fake()->name(),
            'paper'     => fake()->numberBetween(0, 1),
            'audio'     => fake()->numberBetween(0, 1),
            'wishlist'  => fake()->numberBetween(0, 1),
            'link'      => fake()->url(),
            'link_name' => fake()->sentence(6),
            'notes'     => fake()->text(200),
            'seq'       => 0,
            'hidden'       => fake()->numberBetween(0, 1),
            'disabled'  => fake()->numberBetween(0, 1),
        ];
    }
}
