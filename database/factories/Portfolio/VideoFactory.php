<?php

namespace Database\Factories\Portfolio;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Portfolio\Video>
 */
class VideoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition(): array
    {
        return [
            'name'         => fake()->sentence(6),
            'professional' => fake()->numberBetween(0, 1),
            'personal'     => fake()->numberBetween(0, 1),
            'date'         => fake()->date(),
            'year'         => fake()->year(),
            'company'      => fake()->company(),
            'credit'       => fake()->name(),
            'location'     => fake()->city(),
            'link'         => fake()->url(),
            'description'  => fake()->text(200),
            'seq'          => 0,
            'disabled'     => fake()->numberBetween(0, 1),
        ];
    }
}
