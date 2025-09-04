<?php

namespace Database\Factories\Career;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Career\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'application_id' => \App\Models\Career\Application::all()->random()->id,
            'name'           => fake()->words(5),
            'date'           => fake()->date(),
            'time'           => fake()->time(),
            'location'       => fake()->city(),
            'attendees'      => fake()->name(),
            'description'    => fake()->text(200),
            'sequence'       => 0,
            'public'         => 0,
            'readonly'       => 0,
            'root'           => 0,
            'disabled'       => fake()->numberBetween(0, 1),
            'admin_id'       => \App\Models\Admin::all()->random()->id,
        ];
    }
}
