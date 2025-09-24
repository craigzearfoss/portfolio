<?php

use App\Models\Career\Industry;
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
        Schema::connection('career_db')->create('industries', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->unique();
            $table->string('slug', 50)->unique();
            $table->string('abbreviation', 20)->unique();
        });

        $data = [
            [ 'id' => 1,  'name' => 'Agriculture, Forestry & Fishing',    'slug' => 'agriculture-forestry-and-fishing',     'abbreviation' => 'AGR'  ],
            [ 'id' => 2,  'name' => 'Artificial Intelligence',            'slug' => 'artificial-intelligence',              'abbreviation' => 'AI'   ],
            [ 'id' => 3,  'name' => 'Construction',                       'slug' => 'construction',                         'abbreviation' => 'CON'  ],
            [ 'id' => 4,  'name' => 'E-commerce & Online Retail',         'slug' => 'e-commerce-and-online-retail',         'abbreviation' => 'ECO'  ],
            [ 'id' => 5,  'name' => 'Education',                          'slug' => 'education',                            'abbreviation' => 'EDU'  ],
            [ 'id' => 6,  'name' => 'Entertainment & Leisure',            'slug' => 'entertainment-and-leisure',            'abbreviation' => 'ENT'  ],
            [ 'id' => 7,  'name' => 'Finance & Insurance',                'slug' => 'finance-and-insurance',                'abbreviation' => 'FIN'  ],
            [ 'id' => 8,  'name' => 'Government & Public Administration', 'slug' => 'government-and-public-administration', 'abbreviation' => 'GP'   ],
            [ 'id' => 9,  'name' => 'Healthcare',                         'slug' => 'healthcare',                           'abbreviation' => 'HE'   ],
            [ 'id' => 10, 'name' => 'Information Technology',             'slug' => 'information-technology',               'abbreviation' => 'IT'   ],
            [ 'id' => 11, 'name' => 'Legal',                              'slug' => 'legal',                                'abbreviation' => 'LE'   ],
            [ 'id' => 12, 'name' => 'Lodging',                            'slug' => 'lodging',                              'abbreviation' => 'LO'   ],
            [ 'id' => 13, 'name' => 'Manufacturing',                      'slug' => 'manufacturing',                        'abbreviation' => 'MA'   ],
            [ 'id' => 14, 'name' => 'Media & Entertainment',              'slug' => 'media-and-entertainment',              'abbreviation' => 'ME'   ],
            [ 'id' => 15, 'name' => 'Retail',                             'slug' => 'retail',                               'abbreviation' => 'RE'   ],
            [ 'id' => 16, 'name' => 'Real Estate & Property Management',  'slug' => 'real-estate-and-property-management',  'abbreviation' => 'REP'  ],
            [ 'id' => 17, 'name' => 'Telecommunications',                 'slug' => 'telecommunications',                   'abbreviation' => 'TEL'  ],
            [ 'id' => 18, 'name' => 'Transportation & Logistics',         'slug' => 'transportation-and-logistics',         'abbreviation' => 'TRAN' ],
            [ 'id' => 19, 'name' => 'Utilities',                          'slug' => 'utilities',                            'abbreviation' => 'UT'   ],
            [ 'id' => 20, 'name' => 'Wholesale & Distribution',           'slug' => 'wholesale-and-distribution',           'abbreviation' => 'WD'   ],
        ];

        Industry::insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::connection('career_db')->hasTable('companies')) {
            Schema::connection('career_db')->table('companies', function (Blueprint $table) {
                $table->dropForeign('companies_industry_id_foreign');
                $table->dropColumn('industry_id');
            });
        }
        Schema::connection('career_db')->dropIfExists('industries');
    }
};
