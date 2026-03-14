<?php

namespace Database\Factories\Personal;

use App\Models\Personal\Reading;
use App\Models\System\Owner;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Reading>
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
            'owner_id'         => Owner::all()->random()->id,
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
            'is_public'        => 1,
            'is_readonly'      => 0,
            'is_root'          => 0,
            'is_disabled'      => 0,
            'created_at'       => now(),
            'deleted_at'       => now(),
        ];
    }
}
