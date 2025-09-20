<?php

namespace Database\Factories\Career;

use App\Models\Career\Company;
use App\Models\Career\Contact;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Career\CompanyContact>
 */
class CompanyContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'company_id' => Company::all()->random()->id,
            'contact_id' => Contact::all()->random()->id,
        ];
    }
}
