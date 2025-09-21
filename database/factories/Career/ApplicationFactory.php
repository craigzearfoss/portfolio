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
            'role'              => fake()->jobTitle(),
            'rating'            => fake()->numberBetween(0, 4),
            'active'            => 1,
            'post_date'         => fake()->dateTimeBetween('-2 years')->format('Y-m-d'),
            'apply_date'        => fake()->dateTimeBetween('-2 years')->format('Y-m-d'),
            'compensation'      => $amount,
            'compensation_unit' => $unit,
            'duration'          => fake()->randomElement(['permanent', '3 months', '6 months', '1 year']),
            'type_id'           => fake()->numberBetween(1, 5), // 1-permanent,2-contract,3-contract-to-hire,4-temporary,5-project
            'office_id'         => fake()->numberBetween(1, 3), // 1-onsite,2-remote,3-hybrid
            'street'            => fake()->streetAddress(),
            'street2'           => null,
            'city'              => fake()->city(),
            'state'             => fake()->randomElement(\App\Models\State::where('country_id', 237)->get()->pluck('code')->toArray()),
            'zip'               => fake()->postcode(),
            'country'           => 'USA',
            'latitude'          => fake()->randomFloat(4, -90, 90),
            'longitude'         => fake()->randomFloat(4, -180, 180),
            'bonus'             => fake()->randomNumber(4),
            'w2'                => fake()->numberBetween(0, 1),
            'relocation'        => fake()->numberBetween(0, 1),
            'benefits'          => fake()->numberBetween(0, 1),
            'vacation'          => fake()->numberBetween(0, 1),
            'health'            => fake()->numberBetween(0, 1),
            'job_board_id'      => \App\Models\Career\JobBoard::all()->random()->id,
            'phone'             => fake()->phoneNumber(),
            'phone_label'       => 'work',
            'alt_phone'         => fake()->phoneNumber(),
            'alt_phone_label'   => fake()->randomElement(['home', 'mobile', 'pager']),
            'email'             => fake()->companyEmail(),
            'email_label'       => 'work',
            'alt_email'         => fake()->companyEmail(),
            'alt_email_label'   => fake()->randomElement(['personal', 'alternate']),
            'link'              => fake()->url(),
            'link_name'         => fake()->text(20),
            'description'       => fake()->text(200),
            'image'             => fake()->imageUrl(),
            'image_credit'      => fake()->name(),
            'image_source'      => fake()->company(0),
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
