<?php

use App\Models\Career\Company;
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
        Schema::connection('career_db')->create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->foreignIdFor(Industry::class);
            $table->string('street')->nullable();
            $table->string('street2')->nullable();
            $table->string('city', 100)->nullable();
            $table->integer('state_id')->nullable();
            $table->string('zip', 20)->nullable();
            $table->integer('country_id')->nullable();
            $table->float('longitude')->nullable();
            $table->float('latitude')->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('phone_label', 255)->nullable();
            $table->string('alt_phone', 20)->nullable();
            $table->string('alt_phone_label', 255)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('email_label', 255)->nullable();
            $table->string('alt_email', 255)->nullable();
            $table->string('alt_email_label', 255)->nullable();
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
            $table->foreignIdFor(\App\Models\Admin::class);
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['admin_id', 'name'], 'admin_id_name_unique');
            $table->unique(['admin_id', 'slug'], 'admin_id_slug_unique');
        });

        $data = [
            [ 'id' => 1,  'name' => 'Cyber Coders',                  'slug' => 'cyber-coders',                  'industry_id' => 10, 'link' => null, 'link_name' => null, 'state_id' => 10,   'country_id' => 237,  'admin_id' => 2  ],
            [ 'id' => 2,  'name' => 'Mondo',                         'slug' => 'mondo',                         'industry_id' => 10, 'link' => null, 'link_name' => null, 'state_id' => null, 'country_id' => null, 'admin_id' => 2  ],
            [ 'id' => 3,  'name' => 'Randstad',                      'slug' => 'randstad',                      'industry_id' => 10, 'link' => null, 'link_name' => null, 'state_id' => 24,   'country_id' => 237,  'admin_id' => 2  ],
            [ 'id' => 4,  'name' => 'Infinity Consulting Solutions', 'slug' => 'infinity-consulting-solutions', 'industry_id' => 10, 'link' => null, 'link_name' => null, 'state_id' => 24,   'country_id' => 237,  'admin_id' => 2  ],
            [ 'id' => 5,  'name' => 'LinkUp',                        'slug' => 'linkup',                        'industry_id' => 10, 'link' => null, 'link_name' => null, 'state_id' => null, 'country_id' => null, 'admin_id' => 2  ],
            [ 'id' => 6,  'name' => 'Artech',                        'slug' => 'artech',                        'industry_id' => 10, 'link' => null, 'link_name' => null, 'state_id' => null, 'country_id' => null, 'admin_id' => 2  ],
            [ 'id' => 7,  'name' => 'Payzer',                        'slug' => 'payzer',                        'industry_id' => 10, 'link' => null, 'link_name' => null, 'state_id' => 34,   'country_id' => 237,  'admin_id' => 2  ],
            [ 'id' => 8,  'name' => 'Horizontal Talent',             'slug' => 'horizontal-talent',             'industry_id' => 10, 'link' => null, 'link_name' => null, 'state_id' => null, 'country_id' => null, 'admin_id' => 2  ],
            [ 'id' => 9,  'name' => 'Robert Half',                   'slug' => 'robert-half',                   'industry_id' => 10, 'link' => null, 'link_name' => null, 'state_id' => null, 'country_id' => null, 'admin_id' => 2  ],
            [ 'id' => 10, 'name' => 'BI Worldwide',                  'slug' => 'bi-worldwide',                  'industry_id' => 10, 'link' => null, 'link_name' => null, 'state_id' => 24,   'country_id' => 237,  'admin_id' => 2  ],
            [ 'id' => 11, 'name' => 'Illuminate Education',          'slug' => 'illuminate-education',          'industry_id' => 10, 'link' => null, 'link_name' => null, 'state_id' => 24,   'country_id' => 237,  'admin_id' => 2  ],
            [ 'id' => 12, 'name' => 'Trovasearch for Site Impact',   'slug' => 'trovasearch-for-site-impact',   'industry_id' => 10, 'link' => null, 'link_name' => null, 'state_id' => null, 'country_id' => null, 'admin_id' => 2  ],
            [ 'id' => 13, 'name' => 'Disney Studios',                'slug' => 'disney-studios',                'industry_id' => 10, 'link' => null, 'link_name' => null, 'state_id' => null, 'country_id' => null, 'admin_id' => 2  ],
            [ 'id' => 14, 'name' => 'Y Scouts',                      'slug' => 'y-scouts',                      'industry_id' => 10, 'link' => null, 'link_name' => null, 'state_id' => null, 'country_id' => null, 'admin_id' => 2  ],
            [ 'id' => 15, 'name' => 'Talent Fish',                   'slug' => 'talent-fish',                   'industry_id' => 10, 'link' => null, 'link_name' => null, 'state_id' => null, 'country_id' => null, 'admin_id' => 2  ],
            [ 'id' => 16, 'name' => 'Travelnet Solutions Inc',       'slug' => 'travelnet-solutions-inc',       'industry_id' => 10, 'link' => null, 'link_name' => null, 'state_id' => 24,   'country_id' => 237,  'admin_id' => 2  ],
            [ 'id' => 17, 'name' => 'University of Minnesota',       'slug' => 'university-of-minnesota',       'industry_id' => 10, 'link' => null, 'link_name' => null, 'state_id' => 24,   'country_id' => 237,  'admin_id' => 2  ],
            [ 'id' => 18, 'name' => 'Thomas Arts',                   'slug' => 'thomas-arts',                   'industry_id' => 10, 'link' => null, 'link_name' => null, 'state_id' => 24,   'country_id' => 237,  'admin_id' => 2  ],
            [ 'id' => 19, 'name' => 'Next Ethos Group',              'slug' => 'next-ethos-group',              'industry_id' => 10, 'link' => null, 'link_name' => null, 'state_id' => null, 'country_id' => null, 'admin_id' => 2  ],
            [ 'id' => 20, 'name' => 'CSS Staffing',                  'slug' => 'css-staffing',                  'industry_id' => 10, 'link' => null, 'link_name' => null, 'state_id' => null, 'country_id' => null, 'admin_id' => 2  ],
            [ 'id' => 21, 'name' => 'Klaviyo',                       'slug' => 'klaviyo',                       'industry_id' => 10, 'link' => null, 'link_name' => null, 'state_id' => null, 'country_id' => null, 'admin_id' => 2  ],
            [ 'id' => 22, 'name' => 'LendFlow',                      'slug' => 'lendflow',                      'industry_id' => 10, 'link' => null, 'link_name' => null, 'state_id' => 44,   'country_id' => 237,  'admin_id' => 2  ],
            [ 'id' => 23, 'name' => 'Nagios',                        'slug' => 'nagios',                        'industry_id' => 10, 'link' => null, 'link_name' => null, 'state_id' => null, 'country_id' => null, 'admin_id' => 2  ],
            [ 'id' => 24, 'name' => 'Guardian RFID',                 'slug' => 'guardian-rfid',                 'industry_id' => 10, 'link' => null, 'link_name' => null, 'state_id' => null, 'country_id' => null, 'admin_id' => 2  ],
            [
                'id'          => 25,
                'name'        => 'JOBS by allUP',
                'slug'        => 'jobs-by-allup',
                'industry_id' => 10,
                'link'        => 'https://www.linkedin.com/company/jobs-by-allup/jobs/',
                'link_name'   => 'LinkedIn',
                'state_id'    => null,
                'country_id'  => 237,
                'admin_id'    => 2,
            ],
            [
                'id'          => 26,
                'name'        => 'iostudio',
                'slug'        => 'iostudio',
                'industry_id' => 28,
                'link'        => 'https://iostudio.com/',
                'link_name'   => 'iostudio website',
                'state_id'    => null,
                'country_id'  => 237,
                'admin_id'    => 2,
            ],
            [
                'id'          => 27,
                'name'        => 'Black Airplane',
                'slug'        => 'black-airplane',
                'industry_id' => 10,
                'link'        => 'https://blackairplane.com/',
                'link_name'   => 'Black Airplane website',
                'state_id'    => null,
                'country_id'  => 237,
                'admin_id'    => 2,
            ],
            /*
            [
                'id'          => 1,
                'name'        => '',
                'slug'        => '',
                'industry_id' => 10,
                'link'        => null,
                'link_name'   => null,
                'country_id'  => 237,
                'admin_id'    => 2,
            ],
            */
        ];

        Company::insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::connection('career_db')->hasTable('applications')) {
            Schema::connection('career_db')->table('applications', function (Blueprint $table) {
                $table->dropForeign('applications_company_id_foreign');
                $table->dropColumn('company_id');
            });
        }

        Schema::connection('career_db')->dropIfExists('companies');
    }
};
