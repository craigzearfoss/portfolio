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
        $name = fake()->unique()->words(5, true);
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
            $version = null;
        } else {
            $language = array_rand($languages,  1)[0];
            $version = ($language == 'JavaScript')
                ? 'ES' . random_int($languages[0], $languages[1])
                : 'v' . random_int($languages[0], $languages[1]);
        }

        return [
            'name'            => $name,
            'slug'            => $slug,
            'professional'    => fake()->numberBetween(0, 1),
            'personal'        => fake()->numberBetween(0, 1),
            'year'            => fake()->numberBetween(2000, 2025),
            'repository'      => fake()->url(),
            'language'        => $language,
            'version'         => $version,
            'repository_url'  => fake()->url(),
            'repository_name' => fake()->words(5, true),
            'link'            => fake()->url(),
            'link_name'       => fake()->words(5, true),
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
