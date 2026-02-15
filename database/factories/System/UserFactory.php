<?php

namespace Database\Factories\System;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\System\User>
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
            'username'          => fake()->unique()->userName(),
            'name'              => fake()->name(),
            'title'             => fake()->randomElement(\App\Models\System\User::titleListOptions([], true, true)),
            'street'            => fake()->streetAddress(),
            'street2'           => null,
            'city'              => fake()->city(),
            'state_id'          => fake()->numberBetween(1,51),
            'zip'               => fake()->postcode(),
            'country_id'        => 237,
            'latitude'          => fake()->randomFloat(4, -90, 90),
            'longitude'         => fake()->randomFloat(4, -180, 180),
            'phone'             => fake()->phoneNumber(),
            'email'             => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'link'              => fake()->url(),
            'link_name'         => fake()->text(20),
            'description'       => fake()->text(),
            'image'             => fake()->imageUrl(),
            'image_credit'      => fake()->name(),
            'image_source'      => fake()->company(),
            'thumbnail'         => fake()->imageUrl(),
            'password'          => static::$password ??= Hash::make('password'),
            'remember_token'    => Str::random(10),
            'status'            => 1,
            'sequence'          => 0,
            'public'            => 0,
            'readonly'          => 0,
            'root'              => 0,
            'disabled'          => fake()->numberBetween(0, 1),
            'created_at'        => now(),
            'deleted_at'        => now(),
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
