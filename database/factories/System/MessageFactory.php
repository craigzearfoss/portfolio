<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\System\Message>
 */
class MessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $msgDateTime = fake()->dateTimeBetween('-2 years', 'now');

        return [
            'name'       => fake()->name(),
            'email'      => fake()->unique()->safeEmail(),
            'subject'    => fake()->sentence(),
            'body'       => fake()->text(200),
            'created_at' => $msgDateTime,
        ];
    }
}
