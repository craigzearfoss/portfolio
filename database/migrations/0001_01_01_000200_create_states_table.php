<?php

use App\Models\State;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection('default_db')->create('states', function (Blueprint $table) {
            $table->id();
            $table->string('code', 10)->unique();
            $table->string('name', 50);
            $table->foreignIdFor( \App\Models\Country::class);
        });

        $data = [
            [ 'id' => 1,  'code' => 'AL', 'name' => 'Alabama',              'country_id' => 237 ],
            [ 'id' => 2,  'code' => 'AK', 'name' => 'Alaska',               'country_id' => 237 ],
            [ 'id' => 3,  'code' => 'AZ', 'name' => 'Arizona',              'country_id' => 237 ],
            [ 'id' => 4,  'code' => 'AR', 'name' => 'Arkansas',             'country_id' => 237 ],
            [ 'id' => 5,  'code' => 'CA', 'name' => 'California',           'country_id' => 237 ],
            [ 'id' => 6,  'code' => 'CO', 'name' => 'Colorado',             'country_id' => 237 ],
            [ 'id' => 7,  'code' => 'CT', 'name' => 'Connecticut',          'country_id' => 237 ],
            [ 'id' => 8,  'code' => 'DE', 'name' => 'Delaware',             'country_id' => 237 ],
            [ 'id' => 9,  'code' => 'DC', 'name' => 'District of Columbia', 'country_id' => 237 ],
            [ 'id' => 10, 'code' => 'FL', 'name' => 'Florida',              'country_id' => 237 ],
            [ 'id' => 11, 'code' => 'GA', 'name' => 'Georgia',              'country_id' => 237 ],
            [ 'id' => 12, 'code' => 'HI', 'name' => 'Hawaii',               'country_id' => 237 ],
            [ 'id' => 13, 'code' => 'ID', 'name' => 'Idaho',                'country_id' => 237 ],
            [ 'id' => 14, 'code' => 'IL', 'name' => 'Illinois',             'country_id' => 237 ],
            [ 'id' => 15, 'code' => 'IN', 'name' => 'Indiana',              'country_id' => 237 ],
            [ 'id' => 16, 'code' => 'IA', 'name' => 'Iowa',                 'country_id' => 237 ],
            [ 'id' => 17, 'code' => 'KS', 'name' => 'Kansas',               'country_id' => 237 ],
            [ 'id' => 18, 'code' => 'KY', 'name' => 'Kentucky',             'country_id' => 237 ],
            [ 'id' => 19, 'code' => 'LA', 'name' => 'Louisiana',            'country_id' => 237 ],
            [ 'id' => 20, 'code' => 'ME', 'name' => 'Maine',                'country_id' => 237 ],
            [ 'id' => 21, 'code' => 'MD', 'name' => 'Maryland',             'country_id' => 237 ],
            [ 'id' => 22, 'code' => 'MA', 'name' => 'Massachusetts',        'country_id' => 237 ],
            [ 'id' => 23, 'code' => 'MI', 'name' => 'Michigan',             'country_id' => 237 ],
            [ 'id' => 24, 'code' => 'MN', 'name' => 'Minnesota',            'country_id' => 237 ],
            [ 'id' => 25, 'code' => 'MS', 'name' => 'Mississippi',          'country_id' => 237 ],
            [ 'id' => 26, 'code' => 'MO', 'name' => 'Missouri',             'country_id' => 237 ],
            [ 'id' => 27, 'code' => 'MT', 'name' => 'Montana',              'country_id' => 237 ],
            [ 'id' => 28, 'code' => 'NE', 'name' => 'Nebraska',             'country_id' => 237 ],
            [ 'id' => 29, 'code' => 'NV', 'name' => 'Nevada',               'country_id' => 237 ],
            [ 'id' => 30, 'code' => 'NH', 'name' => 'New Hampshire',        'country_id' => 237 ],
            [ 'id' => 31, 'code' => 'NJ', 'name' => 'New Jersey',           'country_id' => 237 ],
            [ 'id' => 32, 'code' => 'NM', 'name' => 'New Mexico',           'country_id' => 237 ],
            [ 'id' => 33, 'code' => 'NY', 'name' => 'New York',             'country_id' => 237 ],
            [ 'id' => 34, 'code' => 'NC', 'name' => 'North Carolina',       'country_id' => 237 ],
            [ 'id' => 35, 'code' => 'ND', 'name' => 'North Dakota',         'country_id' => 237 ],
            [ 'id' => 36, 'code' => 'OH', 'name' => 'Ohio',                 'country_id' => 237 ],
            [ 'id' => 37, 'code' => 'OK', 'name' => 'Oklahoma',             'country_id' => 237 ],
            [ 'id' => 38, 'code' => 'OR', 'name' => 'Oregon',               'country_id' => 237 ],
            [ 'id' => 39, 'code' => 'PA', 'name' => 'Pennsylvania',         'country_id' => 237 ],
            [ 'id' => 40, 'code' => 'RI', 'name' => 'Rhode Island',         'country_id' => 237 ],
            [ 'id' => 41, 'code' => 'SC', 'name' => 'South Carolina',       'country_id' => 237 ],
            [ 'id' => 42, 'code' => 'SD', 'name' => 'South Dakota',         'country_id' => 237 ],
            [ 'id' => 43, 'code' => 'TN', 'name' => 'Tennessee',            'country_id' => 237 ],
            [ 'id' => 44, 'code' => 'TX', 'name' => 'Texas',                'country_id' => 237 ],
            [ 'id' => 45, 'code' => 'UT', 'name' => 'Utah',                 'country_id' => 237 ],
            [ 'id' => 46, 'code' => 'VT', 'name' => 'Vermont',              'country_id' => 237 ],
            [ 'id' => 47, 'code' => 'VA', 'name' => 'Virginia',             'country_id' => 237 ],
            [ 'id' => 48, 'code' => 'WA', 'name' => 'Washington',           'country_id' => 237 ],
            [ 'id' => 49, 'code' => 'WV', 'name' => 'West Virginia',        'country_id' => 237 ],
            [ 'id' => 50, 'code' => 'WI', 'name' => 'Wisconsin',            'country_id' => 237 ],
            [ 'id' => 51, 'code' => 'WY', 'name' => 'Wyoming',              'country_id' => 237 ],
            [ 'id' => 52, 'code' => 'AB', 'name' => 'Alberta',                   'country_id' => 42 ],
            [ 'id' => 53, 'code' => 'BC', 'name' => 'British Columbia',          'country_id' => 42 ],
            [ 'id' => 54, 'code' => 'MB', 'name' => 'Manitoba',                  'country_id' => 42 ],
            [ 'id' => 55, 'code' => 'NB', 'name' => 'New Brunswick',             'country_id' => 42 ],
            [ 'id' => 56, 'code' => 'NL', 'name' => 'Newfoundland and Labrador', 'country_id' => 42 ],
            [ 'id' => 57, 'code' => 'NT', 'name' => 'Northwest Territories',     'country_id' => 42 ],
            [ 'id' => 58, 'code' => 'NS', 'name' => 'Nova Scotia',               'country_id' => 42 ],
            [ 'id' => 59, 'code' => 'NU', 'name' => 'Nunavut',                   'country_id' => 42 ],
            [ 'id' => 60, 'code' => 'ON', 'name' => 'Ontario',                   'country_id' => 42 ],
            [ 'id' => 61, 'code' => 'PE', 'name' => 'Prince Edward Island',      'country_id' => 42 ],
            [ 'id' => 62, 'code' => 'QC', 'name' => 'Quebec',                    'country_id' => 42 ],
            [ 'id' => 63, 'code' => 'SK', 'name' => 'Saskatchewan',              'country_id' => 42 ],
            [ 'id' => 64, 'code' => 'YT', 'name' => 'Yukon',                     'country_id' => 42 ],
        ];

        State::insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('default_db')->dropIfExists('states');
    }
};
