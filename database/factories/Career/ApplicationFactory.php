<?php

namespace Database\Factories\Career;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Career\Application>
 */
class ApplicationFactory extends Factory
{
    const COMPENSATION = [
        'hour'    => [ 'min' => 40,    'max' => 120 ],
        'year'    => [ 'min' => 50000, 'max' => 250000 ],
        'month'   => [ 'min' => 1000,  'max' => 20000 ],
        'week'    => [ 'min' => 800,   'max' => 5000 ],
        'day'     => [ 'min' => 160,   'max' => 1000 ],
        'project' => [ 'min' => 10000, 'max' => 30000 ],
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $unit = array_keys(self::COMPENSATION)[rand(0, count(self::COMPENSATION) - 1)];
        $amount = rand(self::COMPENSATION[$unit]['min'], self::COMPENSATION[$unit]['max']);

        return [
            'company_id'        => \App\Models\Career\Company::all()->random()->id,
            'cover_letter_id'   => \App\Models\Career\CoverLetter::all()->random()->id,
            'resume_id'         => \App\Models\Career\Resume::all()->random()->id,
            'role'              => fake()->jobTitle(),
            'rating'            => fake()->numberBetween(1, 4),
            'active'            => 1,
            'post_date'         => fake()->date(),
            'apply_date'        => fake()->date(),
            'close_date'        => null,
            'compensation'      => $amount,
            'compensation_unit' => $unit,
            'duration'          => fake()->randomElement(['permanent', '3 months', '6 months', '1 year']),
            'type'              => fake()->numberBetween(0, 4), // 0-permanent,1-contract, 2-contract-to-hire,3-project,4-temporary
            'office'            => fake()->numberBetween(0, 2), // 0-onsite,1-remote,2-hybrid
            'city'              => fake()->city(),
            'state'             => fake()->randomElement(\App\Models\State::all()->pluck('code')->toArray()),
            'bonus'             => fake()->randomNumber(4),
            'w2'                => fake()->numberBetween(0, 1),
            'relocation'        => fake()->numberBetween(0, 1),
            'benefits'          => fake()->numberBetween(0, 1),
            'vacation'          => fake()->numberBetween(0, 1),
            'health'            => fake()->numberBetween(0, 1),
            'job_board_id'      => \App\Models\Career\JobBoard::all()->random()->id,
            'phone'             => fake()->phoneNumber(),
            'phone_label'       => fake()->randomElement(['home', 'mobile', 'work']),
            'alt_phone'         => fake()->phoneNumber(),
            'alt_phone_label'   => fake()->randomElement(['home', 'mobile', 'work']),
            'email'             => fake()->companyEmail(),
            'email_label'       => fake()->randomElement(['home', 'mobile', 'work']),
            'alt_email'         => fake()->companyEmail(),
            'alt_email_label'   => fake()->randomElement(['home', 'mobile', 'work']),
            'link'              => fake()->url(),
            'link_name'         => fake()->words(3),
            'description'       => fake()->text(200),
            'image'             => fake()->imageUrl(),
            'image_credit'      => fake()->words(3),
            'image_source'      => fake()->words(3),
            'thumbnail'         => fake()->imageUrl(),
            'sequence'          => 0,
            'public'            => 0,
            'readonly'          => 0,
            'root'              => 0,
            'disabled'          => fake()->numberBetween(0, 1),
            'admin_id'          => \App\Models\Admin::all()->random()->id,
        ];
    }
}
