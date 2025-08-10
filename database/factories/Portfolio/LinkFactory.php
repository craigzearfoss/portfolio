<?php

namespace Database\Factories\Portfolio;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Portfolio\Link>
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
            'admin_id'     => \App\Models\Admin::all()->random()->id,
            'name'         => fake()->unique()->sentence(6),
            'slug'         => fake()->unique()->slug(6),
            'professional' => fake()->numberBetween(0, 1),
            'personal'     => fake()->numberBetween(0, 1),
            'url'          => fake()->url(),
            'website'      => fake()->domainName(),
            'description'  => fake()->text(200),
            'sequence'     => 0,
            'public'       => fake()->numberBetween(0, 1),
            'disabled'     => fake()->numberBetween(0, 1),
        ];
    }
}
