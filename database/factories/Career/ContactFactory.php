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
            'name'            => fake()->unique()->name(),
            'slug'            => fake()->unique()->slug(6),
            'title'           => fake()->randomElement(['Miss','Mr.','Mrs.','Ms']),
            'job_title'       => fake()->jobTitle(),
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
            'email'           => fake()->safeEmail(),
            'email_label'     => fake()->randomElement(['home', 'mobile', 'work']),
            'alt_email'       => fake()->safeEmail(),
            'alt_email_label' => fake()->randomElement(['home', 'mobile', 'work']),
            'link'            => fake()->url(),
            'description'     => fake()->text(200),
            'sequence'        => 0,
            'public'          => 0,
            'readonly'        => 0,
            'root'            => 0,
            'disabled'        => fake()->numberBetween(0, 1),
            'admin_id'        => \App\Models\Admin::all()->random()->id,
        ];
    }
}
