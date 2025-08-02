<?php

namespace Database\Seeders;

use App\Models\State;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StateDataSeeder extends Seeder
{
    const STATES = [
        'AL' => 'Alabama',
        'AK' => 'Alaska',
        'AZ' => 'Arizona',
        'AR' => 'Arkansas',
        'CA' => 'California',
        'CO' => 'Colorado',
        'CT' => 'Connecticut',
        'DC' => 'District of Columbia',
        'DE' => 'Delaware',
        'FL' => 'Florida',
        'GA' => 'Georgia',
        'HI' => 'Hawaii',
        'IA' => 'Iowa',
        'ID' => 'Idaho',
        'IL' => 'Illinois',
        'IN' => 'Indiana',
        'KS' => 'K',
        'KY' => 'Kentucky',
        'LA' => 'Louisiana',
        'ME' => 'Maine',
        'MD' => 'Maryland',
        'MA' => 'Massachusetts',
        'MI' => 'Michigan',
        'MN' => 'Minnesota',
        'MS' => 'Mississippi',
        'MT' => 'Montana',
        'NC' => 'North Carolina',
        'ND' => 'North Dakota',
        'NE' => 'Nebraska',
        'NV' => 'Nevada',
        'NJ' => 'New Jersey',
        'NM' => 'New Mexico ',
        'NY' => 'New York',
        'OH' => 'Ohio',
        'OK' => 'Oklahoma',
        'OR' => 'Oregon',
        'PA' => 'Pennsylvania',
        'RI' => 'Rhode Island',
        'SC' => 'South Carolina',
        'SD' => 'South Dakota',
        'TN' => 'Tennessee',
        'TX' => 'Texas',
        'UT' => 'Utah',
        'VT' => 'Vermont',
        'WA' => 'W',
        'WI' => 'Wisconsin',
        'WY' => 'Wyoming',
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (self::STATES as $code=>$name) {
            State::insert([
                'code' => $code,
                'name' => $name,
            ]);
        }
    }
}
