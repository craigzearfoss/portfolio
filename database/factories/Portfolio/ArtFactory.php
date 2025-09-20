<?php

namespace Database\Factories\Portfolio;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Portfolio\Art>
 */
class ArtFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->words(5, true);
        $artist = fake()->name();
        $slug = Str::slug($name
            . (!empty($artist) ? '-by-' . $artist : ''));

        return [
            'name'         => $name,
            'artist'       => $artist,
            'slug'         => $slug,
            'professional' => fake()->numberBetween(0, 1),
            'personal'     => fake()->numberBetween(0, 1),
            'year'         => fake()->numberBetween(1980, 2025),
            'link'         => fake()->url(),
            'link_name'    => fake()->words(5, true),
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
            'admin_id'     => \App\Models\Admin::all()->random()->id,
        ];
    }
}
