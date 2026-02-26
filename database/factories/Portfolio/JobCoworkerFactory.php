<?php

namespace Database\Factories\Portfolio;

use App\Models\Portfolio\Job;
use App\Models\Portfolio\JobCoworker;
use App\Models\System\Owner;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<JobCoworker>
 */
class JobCoworkerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->name();
        $slug = Str::slug($name);

        return [
            'owner_id'        => Owner::all()->random()->id,
            'job_id'          => fake()->randomElement(Job::all()->pluck('id')->toArray()),
            'name'            => $name,
            'title'           => fake()->jobTitle(),
            'level_id'        => fake()->numberBetween([1, 2, 3]), // 1-coworker, 2-superior, 3-subordinate
            'work_phone'      => fake()->phoneNumber(),
            'personal_phone'  => fake()->phoneNumber(),
            'work_email'      => fake()->safeEmail(),
            'personal_email'  => fake()->safeEmail(),
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
