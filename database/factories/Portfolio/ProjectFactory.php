<?php

namespace Database\Factories\Portfolio;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Portfolio\Project>
 */
class ProjectFactory extends Factory
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

        $languages = [
            'Laravel'     => [5, 12],
            'JavaScript'  => [1, 3],
            'React'       => [15, 18],
            'Angular'     => [18, 20],
            'Vue'         => [2, 3],
            'Node'        => [18, 20],
            'Python'      => [2, 3]
        ];

        if (mt_rand(0,1) < .4) {
            $language = null;
            $languageVersion = null;
        } else {
            $language = array_rand($languages);
            $languageVersion = ($language == 'JavaScript')
                ? 'ES' . random_int($languages[$language][0], $languages[$language][1])
                : 'v' . random_int($languages[$language][0], $languages[$language][1]);
        }

        return [
            'name'             => $name,
            'slug'             => $slug,
            'professional'     => fake()->numberBetween(0, 1),
            'personal'         => fake()->numberBetween(0, 1),
            'featured'         => fake()->numberBetween(0, 1),
            'year'             => fake()->numberBetween(2000, 2025),
            'language'         => $language,
            'language_version' => $languageVersion,
            'repository_url'   => fake()->url(),
            'repository_name'  => fake()->text(20),
            'link'             => fake()->url(),
            'link_name'        => fake()->text(20),
            'description'      => fake()->text(200),
            'image'            => fake()->imageUrl(),
            'image_credit'     => fake()->name(),
            'image_source'     => fake()->company(),
            'thumbnail'        => fake()->imageUrl(),
            'sequence'         => 0,
            'public'           => 1,
            'readonly'         => 0,
            'root'             => 0,
            'disabled'         => 0,
            'admin_id'         => \App\Models\Admin::all()->random()->id,
        ];
    }
}
