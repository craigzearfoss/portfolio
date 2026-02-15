<?php

namespace Database\Factories\Portfolio;

use App\Models\System\Owner;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<\App\Models\Portfolio\Art>
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
        $name = fake()->unique()->text(20);
        $artist = fake()->name();
        $slug = Str::slug($name
            . (!empty($artist) ? '-by-' . $artist : ''));

        return [
            'owner_id'     => Owner::all()->random()->id,
            'name'         => $name,
            'artist'       => $artist,
            'slug'         => $slug,
            'featured'     => fake()->numberBetween(0, 1),
            'summary'      => fake()->text(),
            'year'         => fake()->numberBetween(1980, 2025),
            'notes'        => fake()->text(),
            'link'         => fake()->url(),
            'link_name'    => fake()->text(20),
            'description'  => fake()->text(),
            'image'        => fake()->imageUrl(),
            'image_credit' => fake()->name(),
            'image_source' => fake()->company(),
            'thumbnail'    => fake()->imageUrl(),
            'sequence'     => 0,
            'public'       => 1,
            'readonly'     => 0,
            'root'         => 0,
            'disabled'     => 0,
            'created_at'   => now(),
            'deleted_at'    => now(),
        ];
    }
}
