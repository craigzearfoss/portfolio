<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\System\AdminAdminGroup>
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
            'admin_id'       => \App\Models\System\Admin::all()->random()->id,
            'admin_group_id' => \App\Models\System\AdminGroup::all()->random()->id,
        ];
    }
}
