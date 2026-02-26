<?php

namespace Database\Factories\System;

use App\Models\System\User;
use App\Models\System\UserGroup;
use App\Models\System\UserUserGroup;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<UserUserGroup>
 */
class UserUserGroupFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id'       => User::all()->random()->id,
            'user_group_id' => UserGroup::all()->random()->id,
        ];
    }
}
