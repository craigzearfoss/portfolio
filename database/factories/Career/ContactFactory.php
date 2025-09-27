<?php

namespace Database\Factories\Career;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Career\Contact>
 */
class ContactFactory extends Factory
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
            'owner_id'        => \App\Models\Owner::all()->random()->id,
            'name'            => $name,
            'slug'            => $slug,
            'title'           => fake()->randomElement(['Miss','Mr.','Mrs.','Ms', '', null]),
            'job_title'       => fake()->jobTitle(),
            'street'          => fake()->streetAddress(),
            'street2'         => null,
            'city'            => fake()->city(),
            'state_id'        => fake()->numberBetween(1,51),
            'zip'             => fake()->postcode(),
            'country_id'      => 237,
            'latitude'        => fake()->randomFloat(4, -90, 90),
            'longitude'       => fake()->randomFloat(4, -180, 180),
            'phone'           => fake()->phoneNumber(),
            'phone_label'     => 'work',
            'alt_phone'       => fake()->phoneNumber(),
            'alt_phone_label' => fake()->randomElement(['home', 'mobile']),
            'email'           => fake()->safeEmail(),
            'email_label'     => 'work',
            'alt_email'       => fake()->safeEmail(),
            'alt_email_label' => fake()->randomElement(['personal', 'alternate']),
            'link'            => fake()->url(),
            'link_name'       => fake()->text(20),
            'description'     => fake()->text(200),
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
