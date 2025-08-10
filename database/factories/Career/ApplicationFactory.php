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
            'admin_id'          => \App\Models\Admin::all()->random()->id,
            'company_id'        => \App\Models\Career\Company::all()->random()->id,
            'cover_letter_id'   => \App\Models\Career\CoverLetter::all()->random()->id,
            'resume_id'         => \App\Models\Career\Resume::all()->random()->id,
            'role'              => fake()->jobTitle(),
            'rating'            => fake()->numberBetween(1, 4),
            'active'            => 1,
            'post_date'         => fake()->date(),
            'apply_date'        => fake()->date(),
            'close_date'        => null,
            'compensation'      => fake()->numberBetween(80000, 150000),
            'compensation_unit' => fake()->randomElement(['hour', 'year', 'month', 'week', 'day', 'project']),
            'duration'          => fake()->randomElement(['permanent', '3 months', '6 months', '1 year']),
            'type'              => fake()->numberBetween(0, 3), // 0-permanent,1-contract, 2-contract-to-hire,3-project
            'office'            => fake()->numberBetween(0, 2), // 0-onsite,1-remote,2-hybrid
            'city'              => fake()->city(),
            'state'             => fake()->randomElement(['AL','AK','AR','AZ','CA','CO','CT','DC','DE','FL','GA','HI','IA','ID','IL','IN','KS','KY','LA','MA','MD','ME','MI','MN','MS','MT','NC','ND','NE','NJ','NM','NV','NY','OH','OK','OR','PA','RI','SC','SD','TN','TX','UT','VT','WA','WI','WY']),
            'bonus'             => fake()->randomNumber(4),
            'w2'                => fake()->numberBetween(0, 1),
            'relocation'        => fake()->numberBetween(0, 1),
            'benefits'          => fake()->numberBetween(0, 1),
            'vacation'          => fake()->numberBetween(0, 1),
            'health'            => fake()->numberBetween(0, 1),
            'source'            => \App\Models\Career\JobBoard::all()->random()->name,
            'link'              => fake()->url(),
            'contacts'          => fake()->sentence(),
            'phones'            => fake()->sentence(),
            'emails'            => fake()->sentence(),
            'website'           => fake()->url(),
            'description'       => fake()->text(200),
            'sequence'          => 0,
            'public'            => fake()->numberBetween(0, 1),
            'disabled'          => fake()->numberBetween(0, 1),
        ];
    }
}
