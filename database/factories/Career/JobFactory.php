<?php

namespace Database\Factories\Career;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
        $company = fake()->unique()->words(6, true);
        $slug = Str::slug($company);

        return [
            'name'         => $company,
            'slug'         => $slug,
            'role'         => fake()->jobTitle(),
            'start_month'  => fake()->numberBetween([1, 12]),
            'start_year'   => fake()->numberBetween(2000, 2025),
            'end_month'    => fake()->numberBetween([1, 12]),
            'end_year'     => fake()->numberBetween(2000, 2025),
            'summary'      => fake()->sentence(),
            'notes'        => fake()->text(200),
            'street'       => fake()->streetAddress(),
            'street2'      => null,
            'city'         => fake()->city(),
            'state'        => fake()->randomElement(\App\Models\State::all()->pluck('code')->toArray()),
            'zip'          => fake()->postcode(),
            'country'      => fake()->randomElement(\App\Models\Country::all()->pluck('iso_alpha3')->toArray()),
            'longitude'    => null,
            'latitude'     => null,
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
