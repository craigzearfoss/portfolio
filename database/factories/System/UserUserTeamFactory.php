<?php

namespace Database\Factories\System;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\System\UserUserTeam>
 */
class UserUserTeamFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id'      => \App\Models\System\User::all()->random()->id,
            'user_team_id' => \App\Models\System\UserTeam::all()->random()->id,
        ];
    }
}
