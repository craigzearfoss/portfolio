<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AdminAdminGroup>
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
            'admin_id'       => \App\Models\Admin::all()->random()->id,
            'admin_group_id' => \App\Models\AdminGroup::all()->random()->id,
        ];
    }
}
