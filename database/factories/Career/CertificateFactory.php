<?php

namespace Database\Factories\Career;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Career\Certificate>
 */
class CertificateFactory extends Factory
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
            'organization' => fake()->company(),
            'year'         => fake()->year(),
            'receive'      => fake()->date(),
            'expire'       => fake()->date(),
            'professional' => fake()->numberBetween(0, 1),
            'personal'     => fake()->numberBetween(0, 1),
            'link'         => fake()->url(),
            'description'  => fake()->text(200),
            'disabled'     => fake()->numberBetween(0, 1),
        ];
    }
}
