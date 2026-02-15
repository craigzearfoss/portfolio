<?php

namespace Database\Factories\Portfolio;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Portfolio\Publication>
 */
class PublicationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition(): array
    {
        $title = fake()->unique()->text(20);
        $slug = Str::slug($title);

        return [
            'owner_id'          => \App\Models\System\Owner::all()->random()->id,
            'title'             => $title,
            'slug'              => $slug,
            'parent_id'         => null,
            'featured'          => fake()->numberBetween(0, 1),
            'summary'           => fake()->text(),
            'publication_name'  => fake()->company(),
            'publisher'         => fake()->company(),
            'date'              => fake()->dateTimeBetween('-20 years')->format('Y-m-d'),
            'year'              => fake()->numberBetween(1980, date("Y")),
            'credit'            => fake()->name(),
            'fiction'           => fake()->numberBetween(0, 0),
            'nonfiction'        => fake()->numberBetween(0, 0),
            'technical'         => fake()->numberBetween(0, 0),
            'research'          => fake()->numberBetween(0, 0),
            'freelance'         => fake()->numberBetween(0, 0),
            'online'            => fake()->numberBetween(0, 0),
            'novel'             => fake()->numberBetween(0, 0),
            'book'              => fake()->numberBetween(0, 0),
            'textbook'          => fake()->numberBetween(0, 0),
            'story'             => fake()->numberBetween(0, 0),
            'article'           => fake()->numberBetween(0, 0),
            'paper'             => fake()->numberBetween(0, 0),
            'pamphlet'          => fake()->numberBetween(0, 0),
            'poetry'            => fake()->numberBetween(0, 0),
            'publication_url'   => fake()->url(),
            'review_link1'      => fake()->url(),
            'review_link1_name' => fake()->text(20),
            'review_link2'      => fake()->url(),
            'review_link2_name' => fake()->text(20),
            'review_link3'      => fake()->url(),
            'review_link3_name' => fake()->text(20),
            'notes'             => fake()->text(),
            'link'              => fake()->url(),
            'link_name'         => fake()->text(20),
            'description'       => fake()->text(),
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
