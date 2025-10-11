<?php

namespace Database\Factories\Career;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Career\Communication>
 */
class CommunicationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'owner_id'       => \App\Models\System\Owner::all()->random()->id,
            'application_id' => \App\Models\Career\Application::all()->random()->id,
            'subject'        => fake()->text(20),
            'date'           => fake()->dateTimeBetween('-2 years')->format('Y-m-d'),
            'time'           => fake()->time(),
            'body'           => fake()->text(200),
            'sequence'       => 0,
            'public'         => 0,
            'readonly'       => 0,
            'root'           => 0,
            'disabled'       => fake()->numberBetween(0, 1),
            'created_at'     => now(),
            'deleted_at'     => now(),
        ];
    }
}
