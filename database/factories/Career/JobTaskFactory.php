<?php

namespace Database\Factories\Career;

use App\Models\Career\Job;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Career\JobTask>
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
            'job_id'          => fake()->randomElement(Job::all()->pluck('id')->toArray()),
            'summary'         => fake()->sentence(8),
            'link'            => fake()->url(),
            'link_name'       => fake()->words(3, true),
            'description'     => fake()->text(200),
            'notes'           => fake()->text(200),
            'image'           => fake()->imageUrl(),
            'image_credit'    => fake()->name(),
            'image_source'    => fake()->company(),
            'thumbnail'       => fake()->imageUrl(),
            'sequence'        => 0,
            'public'          => 0,
            'readonly'        => 0,
            'root'            => 0,
            'disabled'        => fake()->numberBetween(0, 1),
            'admin_id'        => \App\Models\Admin::all()->random()->id,
        ];
    }
}
