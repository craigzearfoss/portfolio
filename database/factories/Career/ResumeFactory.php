<?php

namespace Database\Factories\Career;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Career\Resume>
 */
class ResumeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'         => fake()->sentence(6),
            'date'         => fake()->date(),
            'link'         => fake()->url(),
            'alt_link'     => fake()->url(),
            'description'  => fake()->text(200),
            'primary'      => fake()->numberBetween(0, 1),
            'public'       => fake()->numberBetween(0, 1),
            'disabled'     => fake()->numberBetween(0, 1),
        ];
    }
}
