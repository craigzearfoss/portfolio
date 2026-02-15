<?php

namespace Database\Factories\Portfolio;

use App\Models\Portfolio\Job;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Portfolio\JobTask>
 */
class JobTaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'owner_id'        => \App\Models\System\Owner::all()->random()->id,
            'job_id'          => fake()->randomElement(Job::all()->pluck('id')->toArray()),
            'summary'         => fake()->sentence(8),
            'notes'           => fake()->text(),
            'link'            => fake()->url(),
            'link_name'       => fake()->text(20),
            'description'     => fake()->text(),
            'image'           => fake()->imageUrl(),
            'image_credit'    => fake()->name(),
            'image_source'    => fake()->company(),
            'thumbnail'       => fake()->imageUrl(),
            'sequence'        => 0,
            'public'          => 0,
            'readonly'        => 0,
            'root'            => 0,
            'disabled'        => fake()->numberBetween(0, 1),
            'created_at'      => now(),
            'deleted_at'      => now(),
        ];
    }
}
