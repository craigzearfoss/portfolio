<?php

use App\Models\Career\Reference;
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
     * The id of the admin who owns the career reference resource.
     *
     * @var int
     */
    protected $ownerId = 2;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection($this->database_tag)->create('references', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Owner::class, 'owner_id');
            $table->string('name');
            $table->string('slug');
            $table->tinyInteger('friend')->default(0);
            $table->tinyInteger('family')->default(0);
            $table->tinyInteger('coworker')->default(0);
            $table->tinyInteger('supervisor')->default(0);
            $table->tinyInteger('subordinate')->default(0);
            $table->tinyInteger('professional')->default(0);
            $table->tinyInteger('other')->default(0);
            $table->foreignIdFor(\App\Models\Career\Company::class, 'company_id')->nullable();
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
            $table->date('birthday')->nullable();
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
            [
                'id'              => 1,
                'name'            => 'Kevin Hemsley',
                'slug'            => 'kevin-hemsley',
                'friend'          => 0,
                'family'          => 0,
                'coworker'        => 0,
                'supervisor'      => 1,
                'subordinate'     => 0,
                'professional'    => 0,
                'other'           => 0,
                'company_id'      => 85,
                'street'          => null,
                'street2'         => null,
                'city'            => 'Rigby',
                'state_id'        => 13,
                'zip'             => null,
                'country_id'      => 237,
                'phone'           => '(208) 526-0507',
                'phone_label'     => 'work',
                'alt_phone'       => '(208) 317-3644',
                'alt_phone_label' => 'mobile',
                'email'           => 'kevin.hemsley@inl.gov',
                'email_label'     => 'work',
                'alt_email'       => null,
                'alt_email_label' => null,
                'birthday'        => null,
                'link'            => 'https://www.linkedin.com/in/kevin-hemsley-a30740132/',
            ],
            [
                'id'              => 2,
                'name'            => 'Paul Davis',
                'slug'            => 'paul-davis',
                'friend'          => 0,
                'family'          => 0,
                'coworker'        => 0,
                'supervisor'      => 1,
                'subordinate'     => 0,
                'professional'    => 0,
                'other'           => 0,
                'company_id'      => 85,
                'street'          => null,
                'street2'         => null,
                'city'            => null,
                'state_id'        => null,
                'zip'             => null,
                'country_id'      => 237,
                'phone'           => '(913) 608-5399',
                'phone_label'     => null,
                'alt_phone'       => null,
                'alt_phone_label' => null,
                'email'           => 'paul.davis@inl.gov',
                'email_label'     => 'work',
                'alt_email'       => 'prtdavis2@yahoo.com',
                'alt_email_label' => 'home',
                'birthday'        => null,
                'link'            => null,
            ],
            [
                'id'              => 3,
                'name'            => 'Alen Kahen',
                'slug'            => 'alen-kahen',
                'friend'          => 0,
                'family'          => 0,
                'coworker'        => 1,
                'supervisor'      => 0,
                'professional'    => 0,
                'subordinate'     => 0,
                'other'           => 0,
                'company_id'      => 85,
                'street'          => null,
                'street2'         => null,
                'city'            => null,
                'state_id'        => 33,
                'zip'             => null,
                'country_id'      => 237,
                'phone'           => '(917) 685-6003',
                'phone_label'     => 'home',
                'alt_phone'       => null,
                'alt_phone_label' => null,
                'email'           => 'akahen@live.com',
                'email_label'     => 'home',
                'alt_email'       => 'alen.kahen@inl.com',
                'alt_email_label' => 'work',
                'birthday'        => null,
                'link'            => null,
            ],
            [
                'id'              => 4,
                'name'            => 'Nancy Gomez Dominguez',
                'slug'            => 'nancy-gomez-dominguez',
                'friend'          => 0,
                'family'          => 0,
                'coworker'        => 1,
                'supervisor'      => 0,
                'subordinate'     => 0,
                'professional'    => 0,
                'other'           => 0,
                'company_id'      => 85,
                'street'          => null,
                'street2'         => null,
                'city'            => null,
                'state_id'        => null,
                'zip'             => null,
                'country_id'      => 237,
                'phone'           => '(603) 779-2707',
                'phone_label'     => 'mobile',
                'alt_phone'       => '(208) 526-4280',
                'alt_phone_label' => 'work',
                'email'           => 'nancy.gomezdominguez@inl.gov',
                'email_label'     => 'work',
                'alt_email'       => 'ngd.00@outlook.com',
                'alt_email_label' => 'home',
                'birthday'        => null,
                'link'            => null,
            ],
            [
                'id'              => 5,
                'name'            => 'Barbara Zearfoss',
                'slug'            => 'barbara-zearfoss',
                'friend'          => 0,
                'family'          => 1,
                'coworker'        => 0,
                'supervisor'      => 0,
                'subordinate'     => 0,
                'professional'    => 0,
                'other'           => 0,
                'company_id'      => null,
                'street'          => '2678 Sunset Lane',
                'street2'         => null,
                'city'            => 'York',
                'state_id'        => 39,
                'zip'             => '17408-9567',
                'country_id'      => 237,
                'phone'           => '(717) 764-1215',
                'phone_label'     => 'home',
                'alt_phone'       => '(717) 891-1207',
                'alt_phone_label' => 'mobile',
                'email'           => 'BZearfoss@aol.com',
                'email_label'     => 'home',
                'alt_email'       => null,
                'alt_email_label' => null,
                'birthday'        => '1942-08-20',
                'link'            => null,
            ],
            [
                'id'              => 6,
                'name'            => 'Mark Zearfoss',
                'slug'            => 'mark-zearfoss',
                'friend'          => 0,
                'family'          => 1,
                'coworker'        => 0,
                'supervisor'      => 0,
                'subordinate'     => 0,
                'professional'    => 0,
                'other'           => 0,
                'company_id'      => null,
                'street'          => '380 Richardson Rd.',
                'street2'         => null,
                'city'            => 'York',
                'state_id'        => 39,
                'zip'             => '17404',
                'country_id'      => 237,
                'phone'           => '(717) 792-7795',
                'phone_label'     => 'home',
                'alt_phone'       => '(717) 332-1415',
                'alt_phone_label' => 'mobile',
                'email'           => 'zearfoss@verizon.net',
                'email_label'     => 'home',
                'alt_email'       => null,
                'alt_email_label' => null,
                'birthday'        => '1962-07-19',
                'link'            => null,
            ],
            [
                'id'              => 7,
                'name'            => 'Doug Zearfoss',
                'slug'            => 'doug-zearfoss',
                'friend'          => 0,
                'family'          => 1,
                'coworker'        => 0,
                'supervisor'      => 0,
                'subordinate'     => 0,
                'professional'    => 0,
                'other'           => 0,
                'company_id'      => null,
                'street'          => '9652 Rolling Rock Way',
                'street2'         => null,
                'city'            => 'Reno',
                'state_id'        => 29,
                'zip'             => '89521',
                'country_id'      => 237,
                'phone'           => '(775) 852-1264',
                'phone_label'     => 'home',
                'alt_phone'       => '(775) 762-0775',
                'alt_phone_label' => 'mobile',
                'email'           => 'DZearfoss@aol.com',
                'email_label'     => 'home',
                'alt_email'       => 'dzearfoss@eigwc.com',
                'alt_email_label' => 'work',
                'birthday'        => '1965-11-25',
                'link'            => null,
            ],
            [
                'id'              => 8,
                'name'            => 'Gary Zearfoss',
                'slug'            => 'gary-zearfoss',
                'friend'          => 0,
                'family'          => 1,
                'coworker'        => 0,
                'supervisor'      => 0,
                'subordinate'     => 0,
                'professional'    => 0,
                'other'           => 0,
                'company_id'      => null,
                'street'          => '2678 Sunset Lane',
                'street2'         => null,
                'city'            => 'York',
                'state_id'        => 39,
                'zip'             => '17408-9567',
                'country_id'      => 237,
                'phone'           => '(717) 764-1215',
                'phone_label'     => 'home',
                'alt_phone'       => null,
                'alt_phone_label' => null,
                'email'           => null,
                'email_label'     => null,
                'alt_email'       => null,
                'alt_email_label' => null,
                'birthday'        => '1941-09-11',
                'link'            => null,
            ],

            [
                'id'              => 9,
                'name'            => 'Maria Arvanitis',
                'slug'            => 'maria-arvanitis',
                'friend'          => 1,
                'family'          => 0,
                'coworker'        => 0,
                'supervisor'      => 0,
                'subordinate'     => 0,
                'professional'    => 0,
                'other'           => 0,
                'company_id'      => null,
                'street'          => '9079 Golden Pond Lane N',
                'street2'         => null,
                'city'            => 'Monticello',
                'state_id'        => 24,
                'zip'             => '55362',
                'country_id'      => 237,
                'phone'           => '(763) 777-2216',
                'phone_label'     => 'mobile',
                'alt_phone'       => null,
                'alt_phone_label' => null,
                'email'           => 'mariaelaine29@yahoo.com',
                'email_label'     => 'home',
                'alt_email'       => null,
                'alt_email_label' => null,
                'birthday'        => '1980-07-30',
                'link'            => null,
            ],
            [
                'id'              => 10,
                'name'            => 'Barbara Smith',
                'slug'            => 'barbara-smith',
                'friend'          => 1,
                'family'          => 0,
                'coworker'        => 0,
                'supervisor'      => 0,
                'subordinate'     => 0,
                'professional'    => 0,
                'other'           => 0,
                'company_id'      => null,
                'street'          => '2041 Warwick Place',
                'street2'         => null,
                'city'            => 'New Braunfels',
                'state_id'        => 44,
                'zip'             => '78130',
                'country_id'      => 237,
                'phone'           => '(830) 221-8713',
                'phone_label'     => 'home',
                'alt_phone'       => null,
                'alt_phone_label' => null,
                'email'           => 'refugeechildrendream@yahoo.com',
                'email_label'     => 'home',
                'alt_email'       => null,
                'alt_email_label' => null,
                'birthday'        => null,
                'link'            => null,
            ],
            [
                'id'              => 11,
                'name'            => 'Abdul Rehazi',
                'slug'            => 'abdul-rehazi',
                'friend'          => 0,
                'family'          => 0,
                'coworker'        => 0,
                'supervisor'      => 0,
                'subordinate'     => 0,
                'professional'    => 1,
                'other'           => 0,
                'company_id'      => null,
                'street'          => '40230 Hwy 27 North',
                'street2'         => 'Suite 130',
                'city'            => 'Davenport',
                'state_id'        => 10,
                'zip'             => '33837-7807',
                'country_id'      => 237,
                'phone'           => '(352) 259-2159',
                'phone_label'     => 'office',
                'alt_phone'       => null,
                'alt_phone_label' => null,
                'email'           => null,
                'email_label'     => null,
                'alt_email'       => null,
                'alt_email_label' => null,
                'birthday'        => null,
                'link'            => null,
            ],


            /*
            [
                'id'              => 1,
                'name'            => '',
                'slug'            => '',
                'friend'          => 0,
                'family'          => 0,
                'coworker'        => 0,
                'supervisor'      => 0,
                'subordinate'     => 0,
                'professional'    => 0,
                'other'           => 0,
                'company_id'      => null,
                'street'          => null,
                'street2'         => null,
                'city'            => null,
                'state_id'        => null,
                'zip'             => null,
                'country_id'      => 237,
                'phone'           => null,
                'phone_label'     => null,
                'alt_phone'       => null,
                'alt_phone_label' => null,
                'email'           => null,
                'email_label'     => null,
                'alt_email'       => null,
                'alt_email_label' => null,
                'link'            => null,
            ],
            */
        ];

        // add timestamps and owner_ids
        for($i=0; $i<count($data);$i++) {
            $data[$i]['created_at'] = now();
            $data[$i]['updated_at'] = now();
            $data[$i]['owner_id']   = $this->ownerId;
        }

        Reference::insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->database_tag)->dropIfExists('references');
    }
};
