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
        $name = fake()->unique()->words(6);
        $slug = str_replace(' ', '-', $name);

        return [
            'name'         => $name,
            'slug'         => $slug,
            'professional' => fake()->numberBetween(0, 1),
            'personal'     => fake()->numberBetween(0, 1),
            'date'         => fake()->date(),
            'year'         => fake()->year(),
            'company'      => fake()->company(),
            'credit'       => fake()->name(),
            'location'     => fake()->city(),
            'link'         => fake()->url(),
            'link_name'    => fake()->words(6),
            'description'  => fake()->text(200),
            'image'        => fake()->imageUrl(),
            'image_credit' => fake()->words(3),
            'image_source' => fake()->words(3),
            'thumbnail'    => fake()->imageUrl(),
            'sequence'     => 0,
            'public'       => 1,
            'readonly'     => 0,
            'root'         => 0,
            'disabled'     => 0,
            'admin_id'     => \App\Models\Admin::all()->random()->id,
        ];
    }
}
