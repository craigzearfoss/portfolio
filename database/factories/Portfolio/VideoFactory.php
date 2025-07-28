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
            'title'       => fake()->sentence(),
            'year'        => fake()->year(),
            'company'     => fake()->company(),
            'credit'      => fake()->name(),
            'location'    => fake()->city(),
            'link'        => fake()->url(),
            'description' => fake()->text(),
        ];
    }
}
