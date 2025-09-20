<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Admin>
 */
class AdminFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'username'          => fake()->unique()->userName(),
            'name'              => fake()->name(),
            'title'             => fake()->randomElement(['Miss','Mr.','Mrs.','Ms', '', null]),
            'street'            => fake()->streetAddress(),
            'street2'           => null,
            'city'              => fake()->city(),
            'state'             => fake()->randomElement(\App\Models\State::all()->pluck('code')->toArray()),
            'zip'               => fake()->postcode(),
            'country'           => fake()->randomElement(\App\Models\Country::all()->pluck('iso_alpha3')->toArray()),
            'latitude'          => null,
            'longitude'         => null,
            'phone'             => fake()->phoneNumber(),
            'email'             => fake()->unique()->safeEmail(),
            'email_verified_at' => fake()->date(),
            'link'              => fake()->url(),
            'link_name'         => fake()->words(3, true),
            'description'       => fake()->text(200),
            'image'             => fake()->imageUrl(),
            'image_credit'      => fake()->name(),
            'image_source'      => fake()->company(),
            'thumbnail'         => fake()->imageUrl(),
            'sequence'          => 0,
            'public'            => 0,
            'readonly'          => 0,
            'root'              => 0,
            'disabled'          => fake()->numberBetween(0, 1),
        ];
    }
}
