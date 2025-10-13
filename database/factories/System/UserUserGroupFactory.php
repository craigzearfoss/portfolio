<?php

namespace Database\Factories\System;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\System\UserUserGroup>
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
            'user_id'       => \App\Models\System\User::all()->random()->id,
            'user_group_id' => \App\Models\System\UserGroup::all()->random()->id,
        ];
    }
}
