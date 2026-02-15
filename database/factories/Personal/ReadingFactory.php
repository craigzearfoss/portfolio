<?php

namespace Database\Factories\Personal;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Personal\Reading>
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
        $title = fake()->unique()->text(20);
        $author = fake()->name();
        $slug = Str::slug($title
            . (!empty($author) ? '-by-' . $author : ''));

        return [
            'owner_id'         => \App\Models\System\Owner::all()->random()->id,
            'title'            => $title,
            'author'           => $author,
            'slug'             => $slug,
            'featured'         => fake()->numberBetween(0, 1),
            'summary'          => fake()->text(),
            'publication_year' => fake()->numberBetween(1750, 2025),
            'fiction'          => fake()->numberBetween(0, 1),
            'nonfiction'       => fake()->numberBetween(0, 1),
            'paper'            => fake()->numberBetween(0, 1),
            'audio'            => fake()->numberBetween(0, 1),
            'wishlist'         => fake()->numberBetween(0, 1),
            'notes'            => fake()->text(),
            'link'             => fake()->url(),
            'link_name'        => fake()->text(20),
            'description'      => fake()->text(),
            'image'            => fake()->imageUrl(),
            'image_credit'     => fake()->name(),
            'image_source'     => fake()->company(),
            'thumbnail'        => fake()->imageUrl(),
            'sequence'         => 0,
            'public'           => 1,
            'readonly'         => 0,
            'root'             => 0,
            'disabled'         => 0,
            'created_at'       => now(),
            'deleted_at'       => now(),
        ];
    }
}
