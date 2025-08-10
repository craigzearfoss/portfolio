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
            'admin_id'        => \App\Models\Admin::all()->random()->id,
            'name'            => fake()->company(),
            'slug'            => fake()->slug(6),
            'industry_id'     => fake()->randomElement(\App\Models\Career\Industry::all()->pluck('id')->toArray()),
            'street'          => fake()->streetAddress(),
            'street2'         => null,
            'city'            => fake()->city(),
            'state'           => fake()->randomElement(\App\Models\State::all()->pluck('code')->toArray()),
            'zip'             => fake()->postcode(),
            'country'         => fake()->randomElement(\App\Models\Country::all()->pluck('iso_alpha3')->toArray()),
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
            'sequence'        => 0,
            'public'          => fake()->numberBetween(0, 1),
            'disabled'        => fake()->numberBetween(0, 1),
        ];
    }
}
