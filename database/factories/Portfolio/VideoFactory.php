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
        $name = fake()->unique()->text(20);
        $slug = Str::slug($name);

        return [
            'name'         => $name,
            'slug'         => $slug,
            'professional' => fake()->numberBetween(0, 1),
            'personal'     => fake()->numberBetween(0, 1),
            'date'         => fake()->dateTimeBetween('-20 years')->format('Y-m-d'),
            'year'         => fake()->numberBetween(1980, date("Y")),
            'company'      => fake()->company(),
            'credit'       => fake()->name(),
            'location'     => fake()->city(),
            'embed'        => null,
            'link'         => fake()->url(),
            'link_name'    => fake()->text(20),
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
