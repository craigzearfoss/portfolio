<?php

namespace Database\Factories\Portfolio;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Portfolio\Job>
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
        $company = fake()->unique()->company();
        $role = fake()->jobTitle();
        $slug = Str::slug($company . ' (' . $role . ')');

        return [
            'owner_id'     => \App\Models\Owner::all()->random()->id,
            'company'      => $company,
            'role'         => $role,
            'slug'         => $slug,
            'featured'     => fake()->numberBetween(0, 1),
            'summary'      => fake()->text(200),
            'start_month'  => fake()->numberBetween([1, 12]),
            'start_year'   => fake()->numberBetween(2000, 2025),
            'end_month'    => fake()->numberBetween([1, 12]),
            'end_year'     => fake()->numberBetween(2000, 2025),
            'street'       => fake()->streetAddress(),
            'street2'      => null,
            'city'         => fake()->city(),
            'state_id'     => fake()->numberBetween(1,51),
            'zip'          => fake()->postcode(),
            'country_id'   => 237,
            'latitude'     => fake()->randomFloat(4, -90, 90),
            'longitude'    => fake()->randomFloat(4, -180, 180),
            'notes'        => fake()->text(200),
            'link'         => fake()->url(),
            'link_name'    => fake()->text(20),
            'description'  => fake()->text(200),
            'image'        => fake()->imageUrl(),
            'image_credit' => fake()->name(),
            'image_source' => fake()->company(),
            'thumbnail'    => fake()->imageUrl(),
            'sequence'     => 0,
            'public'       => 0,
            'readonly'     => 0,
            'root'         => 0,
            'disabled'     => fake()->numberBetween(0, 1),
            'created_at'   => now(),
            'deleted_at'   => now(),
        ];
    }
}
