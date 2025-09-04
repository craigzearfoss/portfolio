<?php

namespace Database\Factories\Portfolio;

use Illuminate\Database\Eloquent\Factories\Factory;

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
        $name = fake()->unique()->sentence(6);
        $slug = str_replace(' ', '-', $name);

        return [
            'name'           => $name,
            'slug'           => $slug,
            'professional'   => fake()->numberBetween(0, 1),
            'personal'       => fake()->numberBetween(0, 1),
            'artist'         => fake()->name(),
            'label'          => fake()->company(),
            'year'           => fake()->year(),
            'release_date'   => fake()->date(),
            'catalog_number' => fake()->regexify('[A-Z]{3}-[0-9]{6}'),
            'link'           => fake()->url(),
            'link_name'      => fake()->words(6),
            'description'    => fake()->text(200),
            'image'          => fake()->imageUrl(),
            'image_credit'   => fake()->words(3),
            'image_source'   => fake()->words(3),
            'thumbnail'      => fake()->imageUrl(),
            'sequence'       => 0,
            'public'         => 1,
            'readonly'       => 0,
            'root'           => 0,
            'disabled'       => 0,
            'admin_id'       => \App\Models\Admin::all()->random()->id,
        ];
    }
}
