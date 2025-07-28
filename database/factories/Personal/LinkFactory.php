<?php

namespace Database\Factories\Personal;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Personal\Link>
 */
class LinkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'        => fake()->sentence(),
            'url'         => fake()->url(),
            'website'     => fake()-> company(),
            'description' => fake()->text(200),
        ];
    }
}
