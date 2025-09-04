<?php

namespace Database\Factories\Portfolio;

use App\Models\Portfolio\Academy;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Portfolio\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->words(6, true);
        $slug = str_replace(' ', '-', $name);

        return [
            'name'         => $name,
            'slug'         => $slug,
            'professional' => fake()->numberBetween(0, 1),
            'personal'     => fake()->numberBetween(0, 1),
            'year'         => fake()->year(),
            'completed'    => fake()->date(),
            'academy_id'   => fake()->randomElement(Academy::all()->pluck('id')->toArray()),
            'school'       => fake()->company(),
            'instructor'   => fake()->name(),
            'sponsor'      => fake()->company(),
            'link'         => fake()->url(),
            'link_name'    => fake()->words(5, true),
            'description'  => fake()->text(200),
            'image'        => fake()->imageUrl(),
            'image_credit' => fake()->words(3, true),
            'image_source' => fake()->words(3, true),
            'thumbnail'    => fake()->imageUrl(),
            'sequence'     => 0,
            'public'       => 1,
            'readonly'     => 0,
            'root'         => 0,
            'disabled'     => 0,
            'admin_id'     => \App\Models\Admin::all()->random()->id,
        ];
    }
}
