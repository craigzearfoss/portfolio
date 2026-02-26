<?php

namespace Database\Factories\System;

use App\Models\System\User;
use App\Models\System\UserTeam;
use App\Models\System\UserUserTeam;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<UserUserTeam>
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
            'user_id'      => User::all()->random()->id,
            'user_team_id' => UserTeam::all()->random()->id,
        ];
    }
}
