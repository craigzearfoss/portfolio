<?php

namespace Database\Factories\Portfolio;

use App\Models\Portfolio\Link;
use App\Models\System\Owner;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Link>
 */
class LinkFactory extends Factory
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
            'owner_id'     => Owner::all()->random()->id,
            'name'         => $name,
            'slug'         => $slug,
            'featured'     => fake()->numberBetween(0, 1),
            'summary'      => fake()->text(),
            'url'          => fake()->url(),
            'notes'        => fake()->text(),
            'link'         => fake()->url(),
            'link_name'    => fake()->text(20),
            'description'  => fake()->text(),
            'image'        => fake()->imageUrl(),
            'image_credit' => fake()->name(),
            'image_source' => fake()->company(),
            'thumbnail'    => fake()->imageUrl(),
            'sequence'     => 0,
            'is_public'    => 1,
            'is_readonly'  => 0,
            'is_root'      => 0,
            'is_disabled'  => 0,
            'created_at'   => now(),
            'deleted_at'   => now(),
        ];
    }
}
