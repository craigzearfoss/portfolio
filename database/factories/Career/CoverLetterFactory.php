<?php

namespace Database\Factories\Career;

use App\Models\Career\Application;
use App\Models\System\Owner;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\Career\CoverLetter>
 */
class CoverLetterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'owner_id'         => Owner::all()->random()->id,
            'application_id'   => Application::all()->random()->id,
            'date'             => fake()->dateTimeBetween('-2 years')->format('Y-m-d'),
            'url'              => fake()->url(),
            'link'             => fake()->url(),
            'link_name'        => fake()->text(20),
            'description'      => fake()->text(),
            'image'            => fake()->imageUrl(),
            'image_credit'     => fake()->name(),
            'image_source'     => fake()->company(),
            'thumbnail'        => fake()->imageUrl(),
            'sequence'         => 0,
            'public'           => 0,
            'readonly'         => 0,
            'root'             => 0,
            'disabled'         => fake()->numberBetween(0, 1),
            'created_at'       => now(),
            'deleted_at'       => now(),
        ];
    }
}
