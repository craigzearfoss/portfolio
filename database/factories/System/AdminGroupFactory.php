<?php

namespace Database\Factories\System;

use App\Models\System\AdminTeam;
use App\Models\System\Owner;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<\App\Models\System\AdminGroup>
 */
class AdminGroupFactory extends Factory
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
            'owner_id'      => Owner::all()->random()->id,
            'admin_team_id' => AdminTeam::all()->random()->id,
            'name'          => $name,
            'slug '         => $slug,
            'abbreviation'  => $abbreviation,
            'disabled'      => fake()->numberBetween(0, 1),
            'created_at'    => now(),
            'deleted_at'    => now(),
        ];
    }
}
