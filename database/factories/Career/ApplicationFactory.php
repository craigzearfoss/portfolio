<?php

namespace Database\Factories\Career;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Career\Application>
 */
class ApplicationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'role'         => fake()->jobTitle(),
            'rating'       => fake()->numberBetween(1, 4),
            'active'       => 1,
            'post_date'    => fake()->date(),
            'apply_date'   => fake()->date(),
            'close_date'   => null,
            'compensation' => fake()->randomElement(['$100k / yr', '$120k / yr', '$150k / yr', '$90k / yr', '$55 / hr', '$65 / hr', '$70 / hr', '$80 / hr']),
            'duration'     => fake()->randomElement(['permanent', '3 months', '6 months', '1 year']),
            'type'         => fake()->numberBetween(0, 2),
            'office'       => fake()->numberBetween(0, 2),
            'city'         => fake()->city(),
            'state'        => fake()->randomElement(['AL','AK','AR','AZ','CA','CO','CT','DC','DE','FL','GA','HI','IA','ID','IL','IN','KS','KY','LA','MA','MD','ME','MI','MN','MS','MT','NC','ND','NE','NJ','NM','NV','NY','OH','OK','OR','PA','RI','SC','SD','TN','TX','UT','VT','WA','WI','WY']),
            'bonus'        => fake()->randomNumber(4),
            'w2'           => fake()->numberBetween(0, 1),
            'relocation'   => fake()->numberBetween(0, 1),
            'benefits'     => fake()->numberBetween(0, 1),
            'vacation'     => fake()->numberBetween(0, 1),
            'health'       => fake()->numberBetween(0, 1),
            'source'       => fake()->domainName(),
            'link'         => fake()->url(),
            'description'  => fake()->text(200),
        ];
    }
}
