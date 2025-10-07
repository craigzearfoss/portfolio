<?php

use App\Models\Career\Company;
use App\Models\Career\Industry;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * The tag used to identify the career database.
     *
     * @var string
     */
    protected $database_tag = 'career_db';

    /**
     * The id of the admin who owns the career company resource.
     *
     * @var int
     */
    protected $ownerId = 2;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection($this->database_tag)->create('companies', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Owner::class, 'owner_id');
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->foreignIdFor(Industry::class);
            $table->string('street')->nullable();
            $table->string('street2')->nullable();
            $table->string('city', 100)->nullable();
            $table->integer('state_id')->nullable();
            $table->string('zip', 20)->nullable();
            $table->integer('country_id')->nullable();
            $table->float('latitude')->nullable();
            $table->float('longitude')->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('phone_label', 255)->nullable();
            $table->string('alt_phone', 20)->nullable();
            $table->string('alt_phone_label', 255)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('email_label', 255)->nullable();
            $table->string('alt_email', 255)->nullable();
            $table->string('alt_email_label', 255)->nullable();
            $table->string('link', 500)->nullable();
            $table->string('link_name')->nullable();
            $table->text('description')->nullable();
            $table->string('image', 500)->nullable();
            $table->string('image_credit')->nullable();
            $table->string('image_source')->nullable();
            $table->string('thumbnail', 500)->nullable();
            $table->integer('sequence')->default(0);
            $table->tinyInteger('public')->default(0);
            $table->tinyInteger('readonly')->default(0);
            $table->tinyInteger('root')->default(0);
            $table->tinyInteger('disabled')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['owner_id', 'name'], 'owner_id_name_unique');
            $table->unique(['owner_id', 'slug'], 'owner_id_slug_unique');
        });

        $data = [
            [ 'id' => 1,  'name' => 'CyberCoders',                   'slug' => 'cybercoders',                   'industry_id' => 11, 'link' => 'https://www.cybercoders.com/',                     'link_name' => null, 'city' => null, 'state_id' => 10,   'country_id' => 237  ],
            [ 'id' => 2,  'name' => 'Mondo',                         'slug' => 'mondo',                         'industry_id' => 11, 'link' => 'https://mondo.com/',                               'link_name' => null, 'city' => null, 'state_id' => null, 'country_id' => null ],
            [ 'id' => 3,  'name' => 'Randstad',                      'slug' => 'randstad',                      'industry_id' => 11, 'link' => 'https://www.randstadusa.com/',                     'link_name' => null, 'city' => null, 'state_id' => 24,   'country_id' => 237  ],
            [ 'id' => 4,  'name' => 'Infinity Consulting Solutions', 'slug' => 'infinity-consulting-solutions', 'industry_id' => 11, 'link' => null,                                               'link_name' => null, 'city' => null, 'state_id' => 24,   'country_id' => 237  ],
            [ 'id' => 5,  'name' => 'LinkUp',                        'slug' => 'linkup',                        'industry_id' => 11, 'link' => 'https://www.linkup.com/',                          'link_name' => null, 'city' => null, 'state_id' => null, 'country_id' => null ],
            [ 'id' => 6,  'name' => 'Artech',                        'slug' => 'artech',                        'industry_id' => 11, 'link' => 'https://artech.com/',                              'link_name' => null, 'city' => null, 'state_id' => null, 'country_id' => null ],
            [ 'id' => 7,  'name' => 'Payzer',                        'slug' => 'payzer',                        'industry_id' => 4,  'link' => 'https://www.wexfsm.com/about/',                    'link_name' => null, 'city' => null, 'state_id' => 34,   'country_id' => 237, ],
            [ 'id' => 8,  'name' => 'Horizontal Talent',             'slug' => 'horizontal-talent',             'industry_id' => 11, 'link' => 'https://www.horizontaltalent.com/',                'link_name' => null, 'city' => null, 'state_id' => null, 'country_id' => null ],
            [ 'id' => 9,  'name' => 'Robert Half',                   'slug' => 'robert-half',                   'industry_id' => 11, 'link' => 'https://www.roberthalf.com/us/en',                 'link_name' => null, 'city' => null, 'state_id' => null, 'country_id' => null ],
            [ 'id' => 10, 'name' => 'BI Worldwide',                  'slug' => 'bi-worldwide',                  'industry_id' => 11, 'link' => 'https://www.biworldwide.com/',                     'link_name' => null, 'city' => null, 'state_id' => 24,   'country_id' => 237  ],
            [ 'id' => 11, 'name' => 'Illuminate Education',          'slug' => 'illuminate-education',          'industry_id' => 11, 'link' => 'https://www.illuminateed.com/',                    'link_name' => null, 'city' => null, 'state_id' => 24,   'country_id' => 237  ],
            [ 'id' => 12, 'name' => 'Trova',                         'slug' => 'trova',                         'industry_id' => 11, 'link' => 'https://www.trovasearch.com/',                     'link_name' => null, 'city' => null, 'state_id' => null, 'country_id' => null ],
            [ 'id' => 13, 'name' => 'Disney Studios',                'slug' => 'disney-studios',                'industry_id' => 11, 'link' => 'https://www.disneystudios.com/',                   'link_name' => null, 'city' => null, 'state_id' => null, 'country_id' => null ],
            [ 'id' => 14, 'name' => 'Y Scouts',                      'slug' => 'y-scouts',                      'industry_id' => 11, 'link' => 'https://yscouts.com/',                             'link_name' => null, 'city' => null, 'state_id' => null, 'country_id' => null ],
            [ 'id' => 15, 'name' => 'TalentFish',                    'slug' => 'talentfish',                    'industry_id' => 11, 'link' => 'https://talentfish.com/',                          'link_name' => null, 'city' => null, 'state_id' => null, 'country_id' => null ],
            [ 'id' => 16, 'name' => 'Travelnet Solutions',           'slug' => 'travelnet-solutions',           'industry_id' => 11, 'link' => 'https://tnsinc.com/',                              'link_name' => null, 'city' => null, 'state_id' => 24,   'country_id' => 237  ],
            [ 'id' => 17, 'name' => 'University of Minnesota',       'slug' => 'university-of-minnesota',       'industry_id' => 11, 'link' => 'https://twin-cities.umn.edu/',                     'link_name' => null, 'city' => null, 'state_id' => 24,   'country_id' => 237  ],
            [ 'id' => 18, 'name' => 'Thomas Arts',                   'slug' => 'thomas-arts',                   'industry_id' => 11, 'link' => 'https://www.thomasarts.com/',                      'link_name' => null, 'city' => null, 'state_id' => 24,   'country_id' => 237  ],
            [ 'id' => 19, 'name' => 'Next Ethos Group',              'slug' => 'next-ethos-group',              'industry_id' => 11, 'link' => 'https://www.linkedin.com/in/steve-zoltan-722649209/', 'link_name' => null, 'city' => null, 'state_id' => null, 'country_id' => null ],
            [ 'id' => 20, 'name' => 'CSS Staffing',                  'slug' => 'css-staffing',                  'industry_id' => 11, 'link' => 'https://cssstaffing.com/',                         'link_name' => null, 'city' => null, 'state_id' => null, 'country_id' => null ],
            [ 'id' => 21, 'name' => 'Klaviyo',                       'slug' => 'klaviyo',                       'industry_id' => 11, 'link' => 'https://www.klaviyo.com/',                         'link_name' => null, 'city' => null, 'state_id' => null, 'country_id' => null ],
            [ 'id' => 22, 'name' => 'LendFlow',                      'slug' => 'lendflow',                      'industry_id' => 11, 'link' => 'https://www.lendflow.com/',                        'link_name' => null, 'city' => null, 'state_id' => 44,   'country_id' => 237  ],
            [ 'id' => 23, 'name' => 'Nagios',                        'slug' => 'nagios',                        'industry_id' => 11, 'link' => 'https://www.nagios.org/',                          'link_name' => null, 'city' => null, 'state_id' => null, 'country_id' => null ],
            [ 'id' => 24, 'name' => 'Guardian RFID',                 'slug' => 'guardian-rfid',                 'industry_id' => 11, 'link' => 'https://guardianrfid.com/',                        'link_name' => null, 'city' => null, 'state_id' => null, 'country_id' => null ],
            [ 'id' => 25, 'name' => 'Burnout Brands',                'slug' => 'burnout-brands',                'industry_id' => 11, 'link' => 'https://www.linkedin.com/company/burnout-brands/', 'link_name' => null, 'city' => null, 'state_id' => null, 'country_id' => null ],
            [ 'id' => 26, 'name' => 'Quility Insurance Holdings LLC','slug' => 'quility-insurance-holdings-llc','industry_id' => 11, 'link' => 'https://quility.com/',                             'link_name' => null, 'city' => null, 'state_id' => null, 'country_id' => null ],
            [ 'id' => 27, 'name' => 'Divelement Web Services, LLC',  'slug' => 'divelement-web-services-llc',   'industry_id' => 11, 'link' => 'https://divelement.io/',                           'link_name' => null, 'city' => null, 'state_id' => null, 'country_id' => null ],
            [ 'id' => 28, 'name' => 'Givelify',                      'slug' => 'giverlify',                     'industry_id' => 11, 'link' => 'https://www.givelify.com/',                        'link_name' => null, 'city' => null, 'state_id' => null, 'country_id' => null ],
            [ 'id' => 29, 'name' => 'Ingenious',                     'slug' => 'Ingenious',                     'industry_id' => 10, 'link' => 'https://ingenious.agency/',                         'link_name' => null, 'city' => null, 'state_id' => 6,    'country_id' => 237  ],
            [ 'id' => 30, 'name' => 'Advocates for Human Potential, Inc.', 'slug' => 'advocates-for-human-potential-inc', 'industry_id' => 11, 'link' => 'https://ahpnet.com/',                    'link_name' => null, 'city' => null, 'state_id' => 22,   'country_id' => 237  ],
            [ 'id' => 31, 'name' => 'Qualibar Inc',                  'slug' => 'qualibar-inc',                  'industry_id' => 11, 'link' => 'https://qualibar.com/',                            'link_name' => null, 'city' => null, 'state_id' => 11,   'country_id' => 237  ],
            [ 'id' => 32, 'name' => 'MembersFirst',                  'slug' => 'membersfirst',                  'industry_id' => 11, 'link' => 'https://www.membersfirst.com/',                    'link_name' => null, 'city' => null, 'state_id' => 22,   'country_id' => 237  ],
            [ 'id' => 33, 'name' => 'Vultr',                         'slug' => 'vultr',                         'industry_id' => 11, 'link' => 'https://www.vultr.com/',                           'link_name' => null, 'city' => null, 'state_id' => null, 'country_id' => null ],
            [ 'id' => 34, 'name' => 'Inseego',                       'slug' => 'inseego',                       'industry_id' => 11, 'link' => 'https://inseego.com/',                             'link_name' => null, 'city' => null, 'state_id' => null, 'country_id' => null ],
            [ 'id' => 35, 'name' => 'iClassPro, Inc',                'slug' => 'iclasspro-inc',                 'industry_id' => 11, 'link' => 'https://www.iclasspro.com/',                       'link_name' => null, 'city' => null, 'state_id' => 44,   'country_id' => 237  ],
            [ 'id' => 36, 'name' => 'Avolution',                     'slug' => 'avolution',                     'industry_id' => 11, 'link' => 'https://www.avolutionsoftware.com/',               'link_name' => null, 'city' => null, 'state_id' => null, 'country_id' => null ],
            [ 'id' => 37, 'name' => 'McGraw Hill',                   'slug' => 'McGraw Hill',                   'industry_id' => 11, 'link' => 'https://www.mheducation.com/',                     'link_name' => null, 'city' => null, 'state_id' => null, 'country_id' => null ],
            [ 'id' => 38, 'name' => 'Sumas Edge Corporation',        'slug' => 'sumas-edge-corporation',        'industry_id' => 11, 'link' => 'https://sumasedge.com/',                           'link_name' => null, 'city' => null, 'state_id' => 31,   'country_id' => 237  ],
            [ 'id' => 39, 'name' => 'Airbnb',                        'slug' => 'aifbnb',                        'industry_id' => 11, 'link' => 'https://www.airbnb.com/',                          'link_name' => null, 'city' => null, 'state_id' => null, 'country_id' => 237  ],
            [ 'id' => 40, 'name' => 'Wikimedia Foundation',          'slug' => 'wikimedia-foundation',          'industry_id' => 11, 'link' => 'https://wikimediafoundation.org/',                 'link_name' => null, 'city' => null, 'state_id' => null, 'country_id' => null ],
            [ 'id' => 41, 'name' => 'Harbor Compliance',             'slug' => 'harbor-compliance',             'industry_id' => 11, 'link' => 'https://www.harborcompliance.com/',                'link_name' => null, 'city' => null, 'state_id' => null, 'country_id' => null ],
            [ 'id' => 42, 'name' => 'Agital',                        'slug' => 'agital',                        'industry_id' => 11, 'link' => 'https://gofishdigital.com/services/social-commerce/live-shopping/', 'link_name' => null, 'city' => null, 'state_id' => null, 'country_id' => null ],
            [ 'id' => 43, 'name' => 'Sharp Source IT',               'slug' => 'sharp-source-it',               'industry_id' => 11, 'link' => 'https://sharpsourceit.com/',                       'link_name' => null, 'city' => null, 'state_id' => 11,   'country_id' => 237  ],
            [ 'id' => 44, 'name' => 'SPECTRAFORCE Technologies Inc', 'slug' => 'spectraforce-technologies-inc', 'industry_id' => 11, 'link' => 'https://spectraforce.com/',                        'link_name' => null, 'city' => null, 'state_id' => null, 'country_id' => null ],
            [ 'id' => 45, 'name' => 'Ovia Health',                   'slug' => 'ovia-health',                   'industry_id' => 11, 'link' => 'https://www.oviahealth.com/',                      'link_name' => null, 'city' => null, 'state_id' => null, 'country_id' => null ],
            [
                'id'          => 46,
                'name'        => 'JOBS by allUP',
                'slug'        => 'jobs-by-allup',
                'industry_id' => 11,
                'link'        => 'https://www.allup.world/',
                'link_name'   => 'LinkedIn website',
                'city'        => null,
                'state_id'    => null,
                'country_id'  => 237,
            ],
            [
                'id'          => 47,
                'name'        => 'iostudio',
                'slug'        => 'iostudio',
                'industry_id' => 29,
                'link'        => 'https://iostudio.com/',
                'link_name'   => 'iostudio website',
                'city'        => null,
                'state_id'    => null,
                'country_id'  => 237,
            ],
            [
                'id'          => 48,
                'name'        => 'Black Airplane',
                'slug'        => 'black-airplane',
                'industry_id' => 11,
                'link'        => 'https://blackairplane.com/',
                'link_name'   => 'Black Airplane website',
                'city'        => null,
                'state_id'    => null,
                'country_id'  => 237,
            ],
            [
                'id'          => 49,
                'name'        => 'Pacifica Media',
                'slug'        => 'pacifica-media',
                'industry_id' => 11,
                'link'        => 'https://pacificamedia.com/',
                'link_name'   => null,
                'city'        => null,
                'state_id'    => null,
                'country_id'  => 237,
            ],
            [
                'id'          => 50,
                'name'        => 'Parsetek Inc',
                'slug'        => 'parsetek-inc',
                'industry_id' => 11,
                'link'        => 'http://www.parsetek.com/',
                'link_name'   => null,
                'city'        => 'Chantilly',
                'state_id'    => 47,
                'country_id'  => 237,
            ],
            [
                'id'          => 51,
                'name'        => 'Pixels.com',
                'slug'        => 'pixels-com',
                'industry_id' => 11,
                'link'        => 'https://pixels.com/',
                'link_name'   => null,
                'city'        => 'Santa Monica',
                'state_id'    => 5,
                'country_id'  => 237,
            ],
            [
                'id'          => 52,
                'name'        => 'Premier Staffing Partners',
                'slug'        => 'premier-staffing-partners',
                'industry_id' => 11,
                'link'        => 'https://www.premierstaffingpartners.com/',
                'link_name'   => null,
                'city'        => 'Knoxville',
                'state_id'    => 43,
                'country_id'  => 237,
            ],
            [
                'id'          => 53,
                'name'        => 'Printful',
                'slug'        => 'printful',
                'industry_id' => 11,
                'link'        => 'https://www.printful.com/',
                'link_name'   => null,
                'city'        => null,
                'state_id'    => null,
                'country_id'  => 237,
            ],
            [
                'id'          => 55,
                'name'        => 'Reliable Software Resources Inc',
                'slug'        => 'reliable-software-resources-inc',
                'industry_id' => 11,
                'link'        => 'https://www.rsrit.com/',
                'link_name'   => null,
                'city'        => 'Bridgewater',
                'state_id'    => 31,
                'country_id'  => 237,
            ],
            [
                'id'          => 56,
                'name'        => 'Ringside Talent',
                'slug'        => 'ringside-talent',
                'industry_id' => 11,
                'link'        => 'https://ringsidetalent.com/',
                'link_name'   => null,
                'city'        => 'Columbus',
                'state_id'    => 36,
                'country_id'  => 237,
            ],
            [
                'id'          => 57,
                'name'        => 'RIT Solutions',
                'slug'        => 'rit-solutions',
                'industry_id' => 11,
                'link'        => 'https://ritsolinc.jobs.net/',
                'link_name'   => null,
                'city'        => 'Washington',
                'state_id'    => 9,
                'country_id'  => 237,
            ],
            [
                'id'          => 58,
                'name'        => 'RowsOne',
                'slug'        => 'rowsone',
                'industry_id' => 11,
                'link'        => 'https://www.rowshr.com/',
                'link_name'   => null,
                'city'        => null,
                'state_id'    => null,
                'country_id'  => 237,
            ],
            [
                'id'          => 59,
                'name'        => 'Search Solutions, LLC',
                'slug'        => 'search-solutions-llc',
                'industry_id' => 11,
                'link'        => 'https://www.thesearchsolutions.com/',
                'link_name'   => null,
                'city'        => 'Thousand Oaks',
                'state_id'    => 5,
                'country_id'  => 237,
            ],
            [
                'id'          => 60,
                'name'        => 'ServiceNow',
                'slug'        => 'servicenow',
                'industry_id' => 11,
                'link'        => 'https://www.servicenow.com/',
                'link_name'   => null,
                'city'        => null,
                'state_id'    => null,
                'country_id'  => 237,
            ],
            [
                'id'          => 61,
                'name'        => 'SolidProfessor',
                'slug'        => 'solidprofessor',
                'industry_id' => 11,
                'link'        => 'https://solidprofessor.com/',
                'link_name'   => null,
                'city'        => null,
                'state_id'    => null,
                'country_id'  => 237,
            ],
            [
                'id'          => 62,
                'name'        => 'Sun West Mortgage',
                'slug'        => 'sun-west-mortgage',
                'industry_id' => 11,
                'link'        => 'https://www.swmc.com/',
                'link_name'   => null,
                'city'        => null,
                'state_id'    => null,
                'country_id'  => 237,
            ],
            [
                'id'          => 63,
                'name'        => 'Symplicity Corporation',
                'slug'        => 'symplicity-corporation',
                'industry_id' => 11,
                'link'        => 'https://www.symplicity.com/',
                'link_name'   => null,
                'city'        => null,
                'state_id'    => null,
                'country_id'  => 237,
            ],
            [
                'id'          => 64,
                'name'        => 'Think Agency, Inc',
                'slug'        => 'think-agency-inc',
                'industry_id' => 11,
                'link'        => 'https://thinkagency.com/',
                'link_name'   => null,
                'city'        => 'Altamonte Springs',
                'state_id'    => 10,
                'country_id'  => 237,
            ],
            [
                'id'          => 65,
                'name'        => 'Total Expert',
                'slug'        => 'total-expert',
                'industry_id' => 11,
                'link'        => 'https://www.totalexpert.com/',
                'link_name'   => null,
                'city'        => 'St. Louis Park',
                'state_id'    => 24,
                'country_id'  => 237,
            ],
            [
                'id'          => 66,
                'name'        => 'Tukios',
                'slug'        => 'tukios',
                'industry_id' => 11,
                'link'        => 'https://www.tukios.com/',
                'link_name'   => null,
                'city'        => 'Ogden',
                'state_id'    => 45,
                'country_id'  => 237,
            ],
            [
                'id'          => 67,
                'name'        => 'Usked LLC',
                'slug'        => 'usked LLC',
                'industry_id' => 11,
                'link'        => 'http://usked.com/',
                'link_name'   => null,
                'city'        => 'Washington',
                'state_id'    => 9,
                'country_id'  => 237,
            ],
            [
                'id'          => 68,
                'name'        => 'ValoreMVP',
                'slug'        => 'valoremvp',
                'industry_id' => 11,
                'link'        => 'https://valoremvp.com/',
                'link_name'   => 'https://www.vanta.com/',
                'city'        => null,
                'state_id'    => null,
                'country_id'  => 237,
            ],
            [
                'id'          => 69,
                'name'        => 'Vanta',
                'slug'        => 'vanta',
                'industry_id' => 11,
                'link'        => null,
                'link_name'   => null,
                'city'        => null,
                'state_id'    => null,
                'country_id'  => 237,
            ],
            [
                'id'          => 70,
                'name'        => 'Velocity Tech Inc',
                'slug'        => 'velocity-tech-inc',
                'industry_id' => 11,
                'link'        => 'https://velocitytechinc.com/',
                'link_name'   => null,
                'city'        => 'Bedford',
                'state_id'    => 44,
                'country_id'  => 237,
            ],
            [
                'id'          => 71,
                'name'        => 'Veracity Software Inc',
                'slug'        => 'veracity-software-inc',
                'industry_id' => 11,
                'link'        => 'https://veracity-us.com/',
                'link_name'   => null,
                'city'        => null,
                'state_id'    => null,
                'country_id'  => 237,
            ],
            [
                'id'          => 72,
                'name'        => 'Vernovis',
                'slug'        => 'vernovis',
                'industry_id' => 11,
                'link'        => 'https://vernovis.com/',
                'link_name'   => null,
                'city'        => 'Mason',
                'state_id'    => 36,
                'country_id'  => 237,
            ],
            [
                'id'          => 73,
                'name'        => 'VetsEZ',
                'slug'        => 'vetsez',
                'industry_id' => 11,
                'link'        => 'https://vetsez.com/',
                'link_name'   => null,
                'city'        => null,
                'state_id'    => null,
                'country_id'  => 237,
            ],
            [
                'id'          => 74,
                'name'        => 'Victory',
                'slug'        => 'victory',
                'industry_id' => 11,
                'link'        => 'https://victorycto.com/',
                'link_name'   => null,
                'city'        => null,
                'state_id'    => null,
                'country_id'  => 237,
            ],
            [
                'id'          => 75,
                'name'        => 'Vozzi',
                'slug'        => 'vozzi',
                'industry_id' => 11,
                'link'        => 'https://site.getvozzi.com/',
                'link_name'   => null,
                'city'        => 'Salt Lake Ciuy',
                'state_id'    => 45,
                'country_id'  => 237,
            ],
            [
                'id'          => 76,
                'name'        => 'Web Connectivity LLC',
                'slug'        => 'web-connectivity-llc',
                'industry_id' => 11,
                'link'        => 'https://www.webconnectivity.com/',
                'link_name'   => null,
                'city'        => 'Indianapolis',
                'state_id'    => 15,
                'country_id'  => 237,
            ],
            [
                'id'          => 77,
                'name'        => 'WebOrigo',
                'slug'        => 'webOrigo',
                'industry_id' => 11,
                'link'        => 'https://weborigo.com/',
                'link_name'   => null,
                'city'        => null,
                'state_id'    => null,
                'country_id'  => null,
            ],
            [
                'id'          => 78,
                'name'        => 'Zywave',
                'slug'        => 'zywave',
                'industry_id' => 11,
                'link'        => 'https://www.zywave.com/',
                'link_name'   => null,
                'city'        => 'Milwaukee',
                'state_id'    => 50,
                'country_id'  => 237,
            ],
            [
                'id'          => 79,
                'name'        => 'Lumion',
                'slug'        => 'lumion',
                'industry_id' => 11,
                'link'        => 'https://lumion.com/',
                'link_name'   => null,
                'city'        => null,
                'state_id'    => null,
                'country_id'  => 237,
            ],
            [
                'id'          => 80,
                'name'        => 'Regal Cloud',
                'slug'        => 'regal-cloud',
                'industry_id' => 11,
                'link'        => 'https://www.regal-cloud.com/',
                'link_name'   => null,
                'city'        => 'Austin',
                'state_id'    => 44,
                'country_id'  => 237,
            ],
            [
                'id'          => 81,
                'name'        => 'Tyler Technologies, Inc',
                'slug'        => 'tyler-technologies-inc',
                'industry_id' => 11,
                'link'        => 'https://www.tylertech.com/',
                'link_name'   => null,
                'city'        => 'Plano',
                'state_id'    => 44,
                'country_id'  => 237,
            ],
            [
                'id'          => 82,
                'name'        => 'IntertiaJS',
                'slug'        => 'intertiajs',
                'industry_id' => 11,
                'link'        => 'https://inertiajs.com/',
                'link_name'   => null,
                'city'        => null,
                'state_id'    => null,
                'country_id'  => 237,
            ],
            [
                'id'          => 83,
                'name'        => 'Crossing Hurdles',
                'slug'        => 'crossing-hurdles',
                'industry_id' => 11,
                'link'        => 'https://www.linkedin.com/company/crossinghurdles/',
                'link_name'   => null,
                'city'        => null,
                'state_id'    => null,
                'country_id'  => 237,
            ],
            [
                'id'          => 84,
                'name'        => 'USALCO',
                'slug'        => 'usalco',
                'industry_id' => 11,
                'link'        => 'https://www.usalco.com/',
                'link_name'   => null,
                'city'        => 'Baltimore',
                'state_id'    => 21,
                'country_id'  => 237,
            ],
            [
                'id'          => 85,
                'name'        => 'Idaho National Laboratory',
                'slug'        => 'idaho-national-laboratory',
                'industry_id' => 11,
                'link'        => 'https://inl.gov/',
                'link_name'   => null,
                'city'        => 'Idaho Falls',
                'state_id'    => 13,
                'country_id'  => 237,
            ],



            /*
            [
                'id'          => 1,
                'name'        => '',
                'slug'        => '',
                'industry_id' => 11,
                'link'        => null,
                'link_name'   => null,
                'city'        => null,
                'state_id'    => null,
                'country_id'  => 237,
            ],
            */
        ];

        // add timestamps and owner_ids
        for($i=0; $i<count($data);$i++) {
            $data[$i]['created_at'] = now();
            $data[$i]['updated_at'] = now();
            $data[$i]['owner_id']   = $this->ownerId;
        }

        Company::insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->database_tag)->dropIfExists('companies');
    }
};
