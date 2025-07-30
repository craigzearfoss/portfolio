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
            'state'           => fake()->randomElement(['AL','AK','AR','AZ','CA','CO','CT','DC','DE','FL','GA','HI','IA','ID','IL','IN','KS','KY','LA','MA','MD','ME','MI','MN','MS','MT','NC','ND','NE','NJ','NM','NV','NY','OH','OK','OR','PA','RI','SC','SD','TN','TX','UT','VT','WA','WI','WY']),
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
