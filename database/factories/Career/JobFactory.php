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
        return [
            'name'        => fake()->unique()->sentence(6),
            'slug'        => fake()->unique()->slug(6),
            'role'        => fake()->jobTitle(),
            'start_date'  => fake()->date(),
            'end_date'    => fake()->date(),
            'link'        => fake()->url(),
            'description' => fake()->text(200),
            'sequence'    => 0,
            'public'      => 0,
            'readonly'    => 0,
            'root'        => 0,
            'disabled'    => fake()->numberBetween(0, 1),
            'admin_id'    => \App\Models\Admin::all()->random()->id,
        ];
    }
}
