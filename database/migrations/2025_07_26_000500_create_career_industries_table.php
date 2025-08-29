<?php

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
            $table->string('abbreviation', 10)->unique();
            $table->string('link', 10)->unique();
            $table->text('description')->nullable();
            $table->integer('sequence')->default(0);
            $table->tinyInteger('public')->default(1);
            $table->integer('readonly')->default(1);
            $table->integer('root')->default(1);
            $table->tinyInteger('disabled')->default(0);
        });

        $data = [
            [ 'id' => 1,  'name' => 'Agriculture, Forestry & Fishing',    'slug' => 'agriculture-forestry-and-fishing',     'abbreviation' => 'AGR',  'sequence' => 0 ],
            [ 'id' => 2,  'name' => 'Artificial Intelligence',            'slug' => 'artificial-intelligence',              'abbreviation' => 'AI',   'sequence' => 1 ],
            [ 'id' => 3,  'name' => 'Construction',                       'slug' => 'construction',                         'abbreviation' => 'CON',  'sequence' => 2 ],
            [ 'id' => 4,  'name' => 'E-commerce & Online Retail',         'slug' => 'e-commerce-and-online-retail',         'abbreviation' => 'ECO',  'sequence' => 3 ],
            [ 'id' => 5,  'name' => 'Education',                          'slug' => 'education',                            'abbreviation' => 'EDU',  'sequence' => 4 ],
            [ 'id' => 6,  'name' => 'Entertainment & Leisure',            'slug' => 'entertainment-and-leisure',            'abbreviation' => 'ENT',  'sequence' => 5 ],
            [ 'id' => 7,  'name' => 'Finance & Insurance',                'slug' => 'finance-and-insurance',                'abbreviation' => 'FIN',  'sequence' => 6 ],
            [ 'id' => 8,  'name' => 'Government & Public Administration', 'slug' => 'government-and-public-administration', 'abbreviation' => 'GP',   'sequence' => 7 ],
            [ 'id' => 9,  'name' => 'Healthcare',                         'slug' => 'healthcare',                           'abbreviation' => 'HE',   'sequence' => 8 ],
            [ 'id' => 10, 'name' => 'Information Technology',             'slug' => 'information-technology',               'abbreviation' => 'IT',   'sequence' => 9 ],
            [ 'id' => 11, 'name' => 'Legal',                              'slug' => 'legal',                                'abbreviation' => 'LE',   'sequence' => 10 ],
            [ 'id' => 12, 'name' => 'Lodging',                            'slug' => 'lodging',                              'abbreviation' => 'LO',   'sequence' => 11 ],
            [ 'id' => 13, 'name' => 'Manufacturing',                      'slug' => 'manufacturing',                        'abbreviation' => 'MA',   'sequence' => 12 ],
            [ 'id' => 14, 'name' => 'Media & Entertainment',              'slug' => 'media-and-entertainment',              'abbreviation' => 'ME',   'sequence' => 13 ],
            [ 'id' => 15, 'name' => 'Retail',                             'slug' => 'retail',                               'abbreviation' => 'RE',   'sequence' => 14 ],
            [ 'id' => 16, 'name' => 'Real Estate & Property Management',  'slug' => 'real-estate-and-property-management',  'abbreviation' => 'REP',  'sequence' => 15 ],
            [ 'id' => 17, 'name' => 'Telecommunications',                 'slug' => 'telecommunications',                   'abbreviation' => 'TEL',  'sequence' => 16 ],
            [ 'id' => 18, 'name' => 'Transportation & Logistics',         'slug' => 'transportation-and-logistics',         'abbreviation' => 'TRAN', 'sequence' => 17 ],
            [ 'id' => 19, 'name' => 'Utilities',                          'slug' => 'utilities',                            'abbreviation' => 'UT',   'sequence' => 18 ],
            [ 'id' => 20, 'name' => 'Wholesale & Distribution',           'slug' => 'wholesale-and-distribution',           'abbreviation' => 'WD',   'sequence' => 19 ],
        ];
        App\Models\Career\Industry::insert($data);
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
