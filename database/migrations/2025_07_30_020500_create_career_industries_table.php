<?php

use App\Models\Career\Industry;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * @var string
     */
    protected string $database_tag = 'career_db';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection($this->database_tag)->create('industries', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->unique();
            $table->string('slug', 50)->unique();
            $table->string('abbreviation', 20)->unique();
        });

        $data = [
            [ 'id' => 1,  'name' => 'other',                              'slug' => 'other',                                'abbreviation' => 'OTH'  ],
            [ 'id' => 2,  'name' => 'Agriculture, Forestry & Fishing',    'slug' => 'agriculture-forestry-and-fishing',     'abbreviation' => 'AGR'  ],
            [ 'id' => 3,  'name' => 'Artificial Intelligence',            'slug' => 'artificial-intelligence',              'abbreviation' => 'AI'   ],
            [ 'id' => 4,  'name' => 'Construction',                       'slug' => 'construction',                         'abbreviation' => 'CON'  ],
            [ 'id' => 5,  'name' => 'E-commerce & Online Retail',         'slug' => 'e-commerce-and-online-retail',         'abbreviation' => 'ECO'  ],
            [ 'id' => 6,  'name' => 'Education',                          'slug' => 'education',                            'abbreviation' => 'EDU'  ],
            [ 'id' => 7,  'name' => 'Entertainment & Leisure',            'slug' => 'entertainment-and-leisure',            'abbreviation' => 'ENT'  ],
            [ 'id' => 8,  'name' => 'Finance & Insurance',                'slug' => 'finance-and-insurance',                'abbreviation' => 'FIN'  ],
            [ 'id' => 9,  'name' => 'Government & Public Administration', 'slug' => 'government-and-public-administration', 'abbreviation' => 'GP'   ],
            [ 'id' => 0,  'name' => 'Healthcare',                         'slug' => 'healthcare',                           'abbreviation' => 'HE'   ],
            [ 'id' => 11, 'name' => 'Information Technology',             'slug' => 'information-technology',               'abbreviation' => 'IT'   ],
            [ 'id' => 12, 'name' => 'Legal',                              'slug' => 'legal',                                'abbreviation' => 'LE'   ],
            [ 'id' => 13, 'name' => 'Lodging',                            'slug' => 'lodging',                              'abbreviation' => 'LO'   ],
            [ 'id' => 14, 'name' => 'Manufacturing',                      'slug' => 'manufacturing',                        'abbreviation' => 'MA'   ],
            [ 'id' => 15, 'name' => 'Media & Entertainment',              'slug' => 'media-and-entertainment',              'abbreviation' => 'ME'   ],
            [ 'id' => 16, 'name' => 'Retail',                             'slug' => 'retail',                               'abbreviation' => 'RE'   ],
            [ 'id' => 17, 'name' => 'Real Estate & Property Management',  'slug' => 'real-estate-and-property-management',  'abbreviation' => 'REP'  ],
            [ 'id' => 18, 'name' => 'Telecommunications',                 'slug' => 'telecommunications',                   'abbreviation' => 'TEL'  ],
            [ 'id' => 19, 'name' => 'Transportation & Logistics',         'slug' => 'transportation-and-logistics',         'abbreviation' => 'TRAN' ],
            [ 'id' => 20, 'name' => 'Utilities',                          'slug' => 'utilities',                            'abbreviation' => 'UT'   ],
            [ 'id' => 21, 'name' => 'Wholesale & Distribution',           'slug' => 'wholesale-and-distribution',           'abbreviation' => 'WD'   ],
        ];

        Industry::insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->database_tag)->dropIfExists('industries');
    }
};
