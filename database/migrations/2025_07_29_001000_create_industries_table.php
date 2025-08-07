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
        });

        $data = [
            [ 'name' => 'Agriculture, Forestry & Fishing',    'abbreviation' => 'AGR' ],
            [ 'name' => 'Artificial Intelligence',            'abbreviation' => 'AI' ],
            [ 'name' => 'Construction',                       'abbreviation' => 'CON' ],
            [ 'name' => 'E-commerce & Online Retail',         'abbreviation' => 'ECO' ],
            [ 'name' => 'Education',                          'abbreviation' => 'EDU' ],
            [ 'name' => 'Entertainment & Leisure',            'abbreviation' => 'ENT' ],
            [ 'name' => 'Finance & Insurance',                'abbreviation' => 'FIN' ],
            [ 'name' => 'Government & Public Administration', 'abbreviation' => 'GP' ],
            [ 'name' => 'Healthcare',                         'abbreviation' => 'HE' ],
            [ 'name' => 'Information Technology',             'abbreviation' => 'IT' ],
            [ 'name' => 'Legal',                              'abbreviation' => 'LE' ],
            [ 'name' => 'Lodging',                            'abbreviation' => 'LO' ],
            [ 'name' => 'Manufacturing',                      'abbreviation' => 'MA' ],
            [ 'name' => 'Media & Entertainment',              'abbreviation' => 'ME' ],
            [ 'name' => 'Retail',                             'abbreviation' => 'RE' ],
            [ 'name' => 'Real Estate & Property Management',  'abbreviation' => 'REP' ],
            [ 'name' => 'Telecommunications',                 'abbreviation' => 'TEL' ],
            [ 'name' => 'Transportation & Logistics',         'abbreviation' => 'TRAN' ],
            [ 'name' => 'Utilities',                          'abbreviation' => 'UT' ],
            [ 'name' => 'Wholesale & Distribution',           'abbreviation' => 'WD' ],
        ];
        App\Models\Career\JobBoard::insert($data);
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
