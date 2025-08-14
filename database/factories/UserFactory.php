<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
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
            'name'              => fake()->name(),
            'title'             => fake()->randomElement(\App\Models\User::titleListOptions()),
            'street'            => fake()->streetAddress(),
            'street2'           => null,
            'city'              => fake()->city(),
            'state'             => fake()->randomElement(\App\Models\State::all()->pluck('code')->toArray()),
            'zip'               => fake()->postcode(),
            'country'           => fake()->randomElement(\App\Models\Country::all()->pluck('iso_alpha3')->toArray()),
            'phone'             => fake()->phoneNumber(),
            'email'             => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'website'           => fake()->url(),
            'password'          => static::$password ??= Hash::make('password'),
            'remember_token'    => Str::random(10),
            'status'            => 1,
            'disabled'          => fake()->numberBetween(0, 1),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
