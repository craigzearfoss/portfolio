<?php

namespace Database\Factories\System;

use App\Models\System\Message;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Message>
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
        $msgDateTime = fake()->dateTimeBetween('-2 years');

        return [
            'name'       => fake()->name(),
            'email'      => fake()->unique()->safeEmail(),
            'subject'    => fake()->sentence(),
            'body'       => fake()->text(),
            'created_at' => $msgDateTime,
        ];
    }
}
