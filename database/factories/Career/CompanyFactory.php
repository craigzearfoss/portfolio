<?php

namespace Database\Factories\Career;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Career\Company>
 */
class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'            => fake()->company(),
            'street'          => fake()->streetAddress(),
            'street2'         => null,
            'city'            => fake()->city(),
            'state'           => fake()->randomElement(\App\Models\Career\State::all()->pluck('code')->toArray()),
            'zip'             => fake()->postcode(),
            'phone'           => fake()->phoneNumber(),
            'phone_label'     => fake()->randomElement(['home', 'mobile', 'work']),
            'alt_phone'       => fake()->phoneNumber(),
            'alt_phone_label' => fake()->randomElement(['home', 'mobile', 'work']),
            'email'           => fake()->companyEmail(),
            'email_label'     => fake()->randomElement(['home', 'mobile', 'work']),
            'alt_email'       => fake()->companyEmail(),
            'alt_email_label' => fake()->randomElement(['home', 'mobile', 'work']),
            'website'         => fake()->url(),
            'description'     => fake()->text(200),
            'disabled'        => fake()->numberBetween(0, 1),
        ];
    }
}
