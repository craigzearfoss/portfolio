<?php

namespace Database\Factories\Career;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Career\Contact>
 */
class ContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'            => fake()->name(),
            'title'           => fake()->jobTitle(),
            'street'          => fake()->streetAddress(),
            'street2'         => null,
            'city'            => fake()->city(),
            'state'           => fake()->randomElement(\App\Models\Career\State::all()->pluck('code')->toArray()),
            'zip'             => fake()->postcode(),
            'phone'           => fake()->phoneNumber(),
            'phone_label'     => fake()->randomElement(['home', 'mobile', 'work']),
            'alt_phone'       => fake()->phoneNumber(),
            'alt_phone_label' => fake()->randomElement(['home', 'mobile', 'work']),
            'email'           => fake()->safeEmail(),
            'email_label'     => fake()->randomElement(['home', 'mobile', 'work']),
            'alt_email'       => fake()->safeEmail(),
            'alt_email_label' => fake()->randomElement(['home', 'mobile', 'work']),
            'website'         => fake()->url(),
            'description'     => fake()->text(200),
            'disabled'        => fake()->numberBetween(0, 1),
        ];
    }
}
