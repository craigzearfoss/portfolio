<?php

namespace Database\Factories\Portfolio;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Portfolio\Audio>
 */
class AudioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition(): array
    {
        $name = fake()->unique()->text(20);
        $slug = Str::slug($name);

        return [
            'owner_id'          => \App\Models\System\Owner::all()->random()->id,
            'name'              => $name,
            'slug'              => $slug,
            'parent_id'         => null,
            'featured'          => fake()->numberBetween(0, 1),
            'summary'           => fake()->text(200),
            'full_episode'      => fake()->numberBetween(0, 1),
            'clip'              => fake()->numberBetween(0, 1),
            'podcast'           => fake()->numberBetween(0, 1),
            'source_recording'  => fake()->numberBetween(0, 1),
            'date'              => fake()->dateTimeBetween('-20 years')->format('Y-m-d'),
            'year'              => fake()->numberBetween(1980, date("Y")),
            'company'           => fake()->company(),
            'credit'            => fake()->name(),
            'show'              => fake()->text(20),
            'location'          => fake()->city(),
            'embed'             => null,
            'audio_url'         => fake()->url(),
            'review_link1'      => fake()->url(),
            'review_link1_name' => fake()->text(20),
            'review_link2'      => fake()->url(),
            'review_link2_name' => fake()->text(20),
            'review_link3'      => fake()->url(),
            'review_link3_name' => fake()->text(20),
            'notes'             => fake()->text(200),
            'link'              => fake()->url(),
            'link_name'         => fake()->text(20),
            'description'       => fake()->text(200),
            'image'             => fake()->imageUrl(),
            'image_credit'      => fake()->name(),
            'image_source'      => fake()->company(),
            'thumbnail'         => fake()->imageUrl(),
            'sequence'          => 0,
            'public'            => 1,
            'readonly'          => 0,
            'root'              => 0,
            'disabled'          => 0,
            'created_at'        => now(),
            'deleted_at'        => now(),
        ];
    }
}
