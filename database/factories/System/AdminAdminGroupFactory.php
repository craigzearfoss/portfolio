<?php

namespace Database\Factories\System;

use App\Models\System\Admin;
use App\Models\System\AdminGroup;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\System\AdminAdminGroup>
 */
class AdminAdminGroupFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'admin_id'       => Admin::all()->random()->id,
            'admin_group_id' => AdminGroup::all()->random()->id,
        ];
    }
}
