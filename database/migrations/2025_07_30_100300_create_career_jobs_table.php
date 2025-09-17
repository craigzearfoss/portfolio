<?php

use App\Models\Career\Job;
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
        Schema::connection('career_db')->create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('company');
            $table->string('slug')->unique();
            $table->string('street')->nullable();
            $table->string('street2')->nullable();
            $table->string('city', 100);
            $table->string('state', 20);
            $table->string('zip', 20)->nullable();
            $table->string('country', 100);
            $table->float('longitude')->nullable();
            $table->float('latitude')->nullable();
            $table->string('role');
            $table->integer('start_month')->nullable();
            $table->integer('start_year')->nullable();
            $table->integer('end_month')->nullable();
            $table->integer('end_year')->nullable();
            $table->string('summary')->nullable();
            $table->text('notes')->nullable();
            $table->string('link')->nullable();
            $table->string('link_name')->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->string('image_credit')->nullable();
            $table->string('image_source')->nullable();
            $table->string('thumbnail')->nullable();
            $table->integer('sequence')->default(0);
            $table->tinyInteger('public')->default(0);
            $table->tinyInteger('readonly')->default(0);
            $table->tinyInteger('root')->default(0);
            $table->tinyInteger('disabled')->default(0);
            $table->foreignIdFor( \App\Models\Admin::class);
            $table->timestamps();
            $table->softDeletes();
        });

        $data = [
            [ 'id' => 1, 'admin_id' => 1,'company' => 'Idaho National Laboratory',    'slug' => 'idaho-national-laboratory', 'city' => 'Idaho Falls',   'state' => 'ID', 'country' => 'USA', 'role' => 'Senior Software Developer',   'start_month' => 5,  'start_year' => 2021, 'end_month' => null, 'end_year' => null, 'public' => 1, 'summary' => 'Modernized and added new features to a ticketing system for monitoring cyber threats.' ],
            [ 'id' => 2, 'admin_id' => 1,'company' => '3M',                           'slug' => '3m',                        'city' => 'Maplewood',     'state' => 'MN', 'country' => 'USA', 'role' => 'Senior Software Engineer',    'start_month' => 7,  'start_year' => 2019, 'end_month' => 5,    'end_year' => 2021, 'public' => 1, 'summary' => 'Used a rules-based engine to validate 3M product data in an Elasticsearch database.' ],
            [ 'id' => 3, 'admin_id' => 1,'company' => 'Questar Assessment Inc.',      'slug' => 'questar-assessment-inc',    'city' => 'Apple Valley',  'state' => 'MN', 'country' => 'USA', 'role' => 'Senior Software Engineer',    'start_month' => 9,  'start_year' => 2016, 'end_month' => 7,    'end_year' => 2019, 'public' => 1, 'summary' => 'Modernized and added new features to an online exam authoring and delivery system used for state-wide exams.' ],
            [ 'id' => 4, 'admin_id' => 1,'company' => 'Junta LLC',                    'slug' => 'junta-llc',                 'city' => 'Miami Beach',   'state' => 'FL', 'country' => 'USA', 'role' => 'Senior Web Developer',        'start_month' => 2,  'start_year' => 2009, 'end_month' => 9,    'end_year' => 2016, 'public' => 1, 'summary' => 'Created and maintained high traffic multimedia websites.' ],
            [ 'id' => 5, 'admin_id' => 1,'company' => 'Presens Technologies Ltd.',    'slug' => 'presens-technologies-ltd',  'city' => 'Winston-Salem', 'state' => 'NC', 'country' => 'USA', 'role' => 'PHP Web Developer',           'start_month' => 11, 'start_year' => 2006, 'end_month' => 1,    'end_year' => 2009, 'public' => 1, 'summary' => 'Designed and implemented web-based leadership assessments.' ],
            [ 'id' => 6, 'admin_id' => 1,'company' => 'Offut Systems',                'slug' => 'offut-systems',             'city' => 'Greensboro',    'state' => 'NC', 'country' => 'USA', 'role' => 'PHP Developer',               'start_month' => 4,  'start_year' => 2006, 'end_month' => 11,   'end_year' => 2006, 'public' => 1, 'summary' => 'Converted a Linux-based real estate application to Windows for remote agents.' ],
            [ 'id' => 7, 'admin_id' => 1,'company' => 'IBM Desktop Systems / Lenovo', 'slug' => 'ibm-desktop-system-lenovo', 'city' => 'Durham',        'state' => 'NC', 'country' => 'USA', 'role' => 'Software Programmer/Analyst', 'start_month' => 9,  'start_year' => 1992, 'end_month' => 3,    'end_year' => 2006, 'public' => 1, 'summary' => 'Responsible for integrating vendor software for installation on OEM computer systems.' ],
        ];

        Job::insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('career_db')->dropIfExists('jobs');
    }
};
