<?php

namespace Database\Factories\Portfolio;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Portfolio\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'admin_id'     => \App\Models\Admin::all()->random()->id,
            'name'         => fake()->unique()->sentence(6),
            'slug'         => fake()->unique()->slug(6),
            'professional' => fake()->numberBetween(0, 1),
            'personal'     => fake()->numberBetween(0, 1),
            'completed'    => fake()->date(),
            'academy_id'   => fake()->randomElement(\App\Models\Portfolio\Academy::all()->pluck('id')->toArray()),
            'website'      => fake()->domainName(),
            'instructor'   => fake()->name(),
            'sponsor'      => fake()->company(),
            'link'         => fake()->url(),
            'description'  => fake()->text(200),
            'image'        => fake()->imageUrl(),
            'thumbnail'    => fake()->imageUrl(),
            'sequence'     => 0,
            'public'       => fake()->numberBetween(0, 1),
            'disabled'     => fake()->numberBetween(0, 1),
        ];

        $table->id();
        $table->foreignIdFor( \App\Models\Admin::class)->default(1);
        $table->string('name')->unique();
        $table->string('slug')->unique();
        $table->tinyInteger('professional')->default(1);
        $table->tinyInteger('personal')->default(0);
        $table->date('completed')->nullable();
        $table->string('source');
        $table->string('source_website');
        $table->string('instructor');
        $table->text('description')->nullable();
        $table->integer('sequence')->default(0);
        $table->tinyInteger('public')->default(1);
        $table->tinyInteger('disabled')->default(0);
        $table->timestamps();
        $table->softDeletes();

    }
}
