<?php

namespace Database\Factories\Career;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Career\Resume>
 */
class ResumeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'owner_id'     => \App\Models\System\Owner::all()->random()->id,
            'name'         => fake()->text(20),
            'date'         => fake()->dateTimeBetween('-20 years')->format('Y-m-d'),
            'primary'      => fake()->numberBetween(0, 1),
            'content'      => fake()->text(),
            'doc_url'      => fake()->url(),
            'pdf_url'      => fake()->url(),
            'link'         => fake()->url(),
            'link_name'    => fake()->text(20),
            'description'  => fake()->text(),
            'image'        => fake()->imageUrl(),
            'image_credit' => fake()->name(),
            'image_source' => fake()->company(),
            'thumbnail'    => fake()->imageUrl(),
            'sequence'     => 0,
            'public'       => 0,
            'readonly'     => 0,
            'root'         => 0,
            'disabled'     => fake()->numberBetween(0, 1),
            'created_at'   => now(),
            'deleted_at'   => now(),
        ];
    }
}
