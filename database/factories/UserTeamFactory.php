<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserTeam>
 */
class UserTeamFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->lastName();
        $slug = Str::slug($name);
        $abbreviation = strtoupper(fake()->unique()->word());

        return [
            'owner_id'     => \App\Models\Owner::all()->random()->id,
            'name'         => $name,
            'slug '        => $slug,
            'abbreviation' => $abbreviation,
            'disabled'     => fake()->numberBetween(0, 1),
            'created_at'   => now(),
            'deleted_at'   => now(),
        ];
    }
}
