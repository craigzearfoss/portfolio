<?php

namespace Database\Factories\Portfolio;

use App\Models\Portfolio\Academy;
use App\Models\System\Owner;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<\App\Models\Portfolio\Certificate>
 */
class CertificateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->text(20);
        $slug = Str::slug($name);

        return [
            'owner_id'        => Owner::all()->random()->id,
            'name'            => $name,
            'slug'            => $slug,
            'featured'        => fake()->numberBetween(0, 1),
            'summary'         => fake()->text(),
            'organization'    => fake()->company(),
            'academy_id'      => fake()->randomElement(Academy::all()->pluck('id')->toArray()),
            'year'            => fake()->numberBetween(2000, 2025),
            'received'        => fake()->dateTimeBetween('-20 years'),
            'expiration'      => fake()->dateTimeBetween('-20 years'),
            'certificate_url' => fake()->url(),
            'notes'           => fake()->text(),
            'link'            => fake()->url(),
            'link_name'       => fake()->text(20),
            'description'     => fake()->text(),
            'image'           => fake()->imageUrl(),
            'image_credit'    => fake()->name(),
            'image_source'    => fake()->company(),
            'thumbnail'       => fake()->imageUrl(),
            'sequence'        => 0,
            'public'          => 1,
            'readonly'        => 0,
            'root'            => 0,
            'disabled'        => 0,
            'created_at'      => now(),
            'deleted_at'      => now(),
        ];
    }
}
