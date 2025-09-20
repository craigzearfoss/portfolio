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
        $title = fake()->unique()->words(5, true);
        $author = fake()->name();
        $slug = Str::slug($title
            . (!empty($artist) ? '-by-' . $artist : ''));

        return [
            'title'        => $title,
            'author'       => $author,
            'slug'         => $slug,
            'professional' => fake()->numberBetween(0, 1),
            'personal'     => fake()->numberBetween(0, 1),
            'paper'        => fake()->numberBetween(0, 1),
            'audio'        => fake()->numberBetween(0, 1),
            'wishlist'     => fake()->numberBetween(0, 1),
            'link'         => fake()->url(),
            'link_name'    => fake()->words(5, true),
            'description'  => fake()->text(200),
            'image'        => fake()->imageUrl(),
            'image_credit' => fake()->words(3, true),
            'image_source' => fake()->words(3, true),
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
