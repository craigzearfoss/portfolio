<?php

namespace Database\Factories\Career;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Career\Job>
 */
class JobFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->words(6, true);
        $slug = str_replace(' ', '-', $name);

        return [
            'name'         => $name,
            'slug'         => $slug,
            'role'         => fake()->jobTitle(),
            'start_date'   => fake()->date(),
            'end_date'     => fake()->date(),
            'link'         => fake()->url(),
            'link_name'    => fake()->words(4, true),
            'description'  => fake()->text(200),
            'image'        => fake()->imageUrl(),
            'image_credit' => fake()->words(3, true),
            'image_source' => fake()->words(3, true),
            'thumbnail'    => fake()->imageUrl(),
            'sequence'     => 0,
            'public'       => 0,
            'readonly'     => 0,
            'root'         => 0,
            'disabled'     => fake()->numberBetween(0, 1),
            'admin_id'     => \App\Models\Admin::all()->random()->id,
        ];
    }
}
