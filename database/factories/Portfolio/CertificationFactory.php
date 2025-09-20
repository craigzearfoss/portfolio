<?php

namespace Database\Factories\Portfolio;

use App\Models\Portfolio\Academy;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Portfolio\Certification>
 */
class CertificationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->words(5, true);
        $slug = Str::slug($name);

        return [
            'name'            => $name,
            'slug'            => $slug,
            'professional'    => fake()->numberBetween(0, 1),
            'personal'        => fake()->numberBetween(0, 1),
            'organization'    => fake()->company(),
            'academy_id'      => fake()->randomElement(Academy::all()->pluck('id')->toArray()),
            'year'            => fake()->numberBetween(2000, 2025),
            'received'        => fake()->date('-20 years', 'now'),
            'expiration'      => fake()->date('-20 years', 'now'),
            'certificate_url' => fake()->url(),
            'link'            => fake()->url(),
            'link_name'       => fake()->words(6),
            'description'     => fake()->text(200),
            'image'           => fake()->imageUrl(),
            'image_credit'    => fake()->name(),
            'image_source'    => fake()->company(),
            'thumbnail'       => fake()->imageUrl(),
            'sequence'        => 0,
            'public'          => 1,
            'readonly'        => 0,
            'root'            => 0,
            'disabled'        => 0,
            'admin_id'        => \App\Models\Admin::all()->random()->id,
        ];
    }
}
