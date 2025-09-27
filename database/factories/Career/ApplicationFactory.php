<?php

namespace Database\Factories\Career;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Career\Application>
 */
class ApplicationFactory extends Factory
{
    const COMPENSATION = [
        /* [none]  */ 1 => [ 'min' => [40, 60],       'max' => [80, 120]       ],
        /* hour    */ 2 => [ 'min' => [40, 60],       'max' => [80, 120]       ],
        /* year    */ 3 => [ 'min' => [25000, 50000], 'max' => [60000, 200000] ],
        /* month   */ 4 => [ 'min' => [2000, 3000],   'max' => [3000, 20000]   ],
        /* week    */ 5 => [ 'min' => [500, 1800],    'max' => [2000, 4000]    ],
        /* day     */ 6 => [ 'min' => [140, 200],     'max' => [500, 1000]     ],
        /* project */ 7 => [ 'min' => [500, 5000],    'max' => [6000, 30000]   ],
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $compensationUnitId = array_keys(self::COMPENSATION)[rand(0, count(self::COMPENSATION) - 1)];
        $compensationMin = rand(self::COMPENSATION[$compensationUnitId]['min'][0], self::COMPENSATION[$compensationUnitId]['min'][1]);
        $compensationMax = rand(self::COMPENSATION[$compensationUnitId]['max'][0], self::COMPENSATION[$compensationUnitId]['max'][1]);

        return [
            'owner_id'          => \App\Models\Owner::all()->random()->id,
            'company_id'        => \App\Models\Career\Company::all()->random()->id,
            'role'              => fake()->jobTitle(),
            'resume_id'         => \App\Models\Career\Resume::all()->random()->id,
            'rating'            => fake()->numberBetween(0, 4),
            'active'            => 1,
            'post_date'         => fake()->dateTimeBetween('-2 years')->format('Y-m-d'),
            'apply_date'        => fake()->dateTimeBetween('-2 years')->format('Y-m-d'),
            'compensation_min'  => $compensationMin,
            'compensation_max'  => $compensationMax,
            'compensation_unit' => $compensationUnitId,
            'duration'          => fake()->randomElement(['permanent', '3 months', '6 months', '1 year']),
            'type_id'           => fake()->numberBetween(1, 5), // 1-permanent,2-contract,3-contract-to-hire,4-temporary,5-project
            'office_id'         => fake()->numberBetween(1, 3), // 1-onsite,2-remote,3-hybrid
            'schedule_id'       => fake()->numberBetween(1, 2), // 1-full-time,2-part-time
            'street'            => fake()->streetAddress(),
            'street2'           => null,
            'city'              => fake()->city(),
            'state_id'          => fake()->numberBetween(1,51),
            'zip'               => fake()->postcode(),
            'country_id'        => 237,
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
            'created_at'        => now(),
            'deleted_at'        => now(),
        ];
    }
}
