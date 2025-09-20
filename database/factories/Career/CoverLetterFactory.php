<?php

namespace Database\Factories\Career;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Career\CoverLetter>
 */
class CoverLetterFactory extends Factory
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
            'name'          => $name,
            'slug'          => $slug,
            'date'          => fake()->dateTimeBetween('-2 years')->format('Y-m-d'),
            'link'          => fake()->url(),
            'link_name'     => fake()->text(20),
            'alt_link'      => fake()->url(),
            'alt_link_name' => fake()->text(20),
            'description'   => fake()->text(200),
            'image'         => fake()->imageUrl(),
            'image_credit'  => fake()->name(),
            'image_source'  => fake()->company(),
            'thumbnail'     => fake()->imageUrl(),
            'primary'       => fake()->numberBetween(0, 1),
            'sequence'      => 0,
            'public'        => 0,
            'readonly'      => 0,
            'root'          => 0,
            'disabled'      => fake()->numberBetween(0, 1),
            'admin_id'      => \App\Models\Admin::all()->random()->id,
        ];
    }
}
