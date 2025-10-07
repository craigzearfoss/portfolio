<?php

namespace Database\Factories\Portfolio;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Portfolio\Music>
 */
class MusicFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->text(20);
        $artist = fake()->name();
        $slug = Str::slug($name
            . (!empty($artist) ? '-by-' . $artist : ''));

        return [
            'owner_id'       => \App\Models\Owner::all()->random()->id,
            'name'           => $name,
            'artist'         => $artist,
            'slug'           => $slug,
            'featured'       => fake()->numberBetween(0, 1),
            'summary'        => fake()->text(200),
            'collection'     => fake()->numberBetween(0, 1),
            'track'          => fake()->numberBetween(0, 1),
            'label'          => fake()->company(),
            'catalog_number' => fake()->regexify('[A-Z]{3}-[0-9]{6}'),
            'year'           => fake()->numberBetween(2000, 2025),
            'release_date'   => fake()->dateTimeBetween('-20 years')->format('Y-m-d'),
            'embed'          => null,
            'audio_url'      => fake()->url(),
            'notes'          => fake()->text(200),
            'link'           => fake()->url(),
            'link_name'      => fake()->text(20),
            'description'    => fake()->text(200),
            'image'          => fake()->imageUrl(),
            'image_credit'   => fake()->name(),
            'image_source'   => fake()->company(),
            'thumbnail'      => fake()->imageUrl(),
            'sequence'       => 0,
            'public'         => 1,
            'readonly'       => 0,
            'root'           => 0,
            'disabled'       => 0,
            'created_at'     => now(),
            'deleted_at'     => now(),
        ];
    }
}
