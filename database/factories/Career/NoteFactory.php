<?php

namespace Database\Factories\Career;

use App\Models\Career\Application;
use App\Models\Career\Note;
use App\Models\System\Owner;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Note>
 */
class NoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'owner_id'       => Owner::all()->random()->id,
            'application_id' => Application::all()->random()->id,
            'subject'        => fake()->sentence(),
            'body'           => fake()->text(),
            'sequence'       => 0,
            'is_public'      => 0,
            'is_readonly'    => 0,
            'is_root'        => 0,
            'is_disabled'    => fake()->numberBetween(0, 1),
            'created_at'     => now(),
            'deleted_at'     => now(),
        ];
    }
}
