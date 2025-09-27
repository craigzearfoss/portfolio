<?php

use App\Models\Career\Company;
use App\Models\Career\Contact;
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
     * The id of the admin who owns the career contact resource.
     *
     * @var int
     */
    protected $ownerId = 2;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection($this->database_tag)->create('contacts', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Owner::class, 'owner_id');
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->string('title', 20)->nullable();
            $table->string('job_title', 100)->nullable();
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
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['owner_id', 'name'], 'owner_id_name_unique');
            $table->unique(['owner_id', 'slug'], 'owner_id_slug_unique');
        });

        $data = [
            [ 'id' => 1,  'name' => 'Chad Vasquez',     'slug' => 'chad-vasquez',     'phone' => null,	            'phone_label' => null,   'email' => 'Chad.Vasquez@CyberCoders.com',         'email_label' => 'work' ],
            [ 'id' => 2,  'name' => 'Lyman Ambrose',    'slug' => 'lyman-ambrose',    'phone' => null,	            'phone_label' => null,   'email' => 'lyman.ambrose@mondo.com',              'email_label' => 'work' ],
            [ 'id' => 3,  'name' => 'Miles Biegert',    'slug' => 'miles-biegert',    'phone' => null,             'phone_label' => null,   'email' => 'milesb@infinity-cs.com',               'email_label' => 'work' ],
            [ 'id' => 4,  'name' => 'Jolly Nibu',       'slug' => 'jolly-nibu',       'phone' => null,	            'phone_label' => null,   'email' => 'jolly.nibu@artech.com',                'email_label' => 'work' ],
            [ 'id' => 5,  'name' => 'Connor Sullivan',  'slug' => 'connor-sullivan',  'phone' => null,	            'phone_label' => null,   'email' => null,                                   'email_label' => null,  ],
            [ 'id' => 6,  'name' => 'Jordan Luehmann',  'slug' => 'jordan-luehmann',  'phone' => null,	            'phone_label' => null,   'email' => 'jluehmann@horizontal.com',             'email_label' => 'work' ],
            [ 'id' => 7,  'name' => 'Steve Allen',      'slug' => 'steve-allen',      'phone' => null,	            'phone_label' => null,   'email' => null,                                   'email_label' => null   ],
            [ 'id' => 8,  'name' => 'Victor Fung',      'slug' => 'victor-fung',      'phone' => null,             'phone_label' => null,   'email' => null,                                   'email_label' => null   ],
            [ 'id' => 9,  'name' => 'Jessica Chandler', 'slug' => 'jessica-chandler', 'phone' => null,             'phone_label' => null,   'email' => null,                                   'email_label' => null   ],
            [ 'id' => 10, 'name' => 'Donna Morgan',     'slug' => 'donna-morgan',     'phone' => null,             'phone_label' => null,   'email' => null,                                   'email_label' => null   ],
            [ 'id' => 11, 'name' => 'Kirsten Carlson',  'slug' => 'kirsten-carlson',  'phone' => null,	            'phone_label' => null,   'email' => null,                                   'email_label' => null   ],
            [ 'id' => 12, 'name' => 'Kyle Nussberger',  'slug' => 'kyle-nussberger',  'phone' => null,	            'phone_label' => null,   'email' => null,                                   'email_label' => null   ],
            [ 'id' => 13, 'name' => 'Andrew Jones',     'slug' => 'andrew-jones',     'phone' => null,	            'phone_label' => null,   'email' => null,                                   'email_label' => null   ],
            [ 'id' => 14, 'name' => 'Dylan Rogelstad',  'slug' => 'dylan-rogelstad',  'phone' => null,	            'phone_label' => null,   'email' => 'dylan.rogelstad@mail.cybercoders.com', 'email_label' => 'work' ],
            [ 'id' => 15, 'name' => 'Larry Kraynak',    'slug' => 'larry-kraynak',    'phone' => null,	            'phone_label' => null,   'email' => null,                                   'email_label' => null   ],
            [ 'id' => 16, 'name' => 'Tim Lesnick',      'slug' => 'tim-lesnick',      'phone' => null,             'phone_label' => null,   'email' => 'tlesnick@trovasearch.com',             'email_label' => 'work' ],
            [ 'id' => 17, 'name' => 'Ciara Monahan',    'slug' => 'ciara-monahan',    'phone' => null,             'phone_label' => null,   'email' => 'Ciara.Monahan@insightglobal.com',      'email_label' => 'work' ],
            [ 'id' => 18, 'name' => 'Rob Neylon',       'slug' => 'rob-neylon',       'phone' => null,	            'phone_label' => null,   'email' => 'rob@yscouts.com',                      'email_label' => 'work' ],
            [ 'id' => 19, 'name' => 'Billy Bisson',     'slug' => 'billy-bisson',     'phone' => null,	            'phone_label' => null,   'email' => null,                                   'email_label' => null   ],
            [ 'id' => 20, 'name' => 'Kelsey Higgins',   'slug' => 'kelsey-higgins',   'phone' => '(774) 283-1614', 'phone_label' => 'work', 'email' => 'kelsey.higgins@klaviyo.com',           'email_label' => 'work' ],
            [ 'id' => 21, 'name' => 'Britney Coleman',  'slug' => 'britney-coleman',  'phone' => null,	            'phone_label' => null,   'email' => 'coleman@lendflow.io',                  'email_label' => 'work' ],
            [ 'id' => 22, 'name' => 'Dan Chaffee',      'slug' => 'dan-chaffee',      'phone' => null,	            'phone_label' => null,   'email' => null,                                   'email_label' => null   ],
            [ 'id' => 23, 'name' => 'Kara Caldwell',    'slug' => 'kara-caldwell',    'phone' => null,	            'phone_label' => null,   'email' => null,                                   'email_label' => null   ],
        ];

        // add timestamps and owner_ids
        for($i=0; $i<count($data);$i++) {
            $data[$i]['created_at'] = now();
            $data[$i]['updated_at'] = now();
            $data[$i]['owner_id']   = $this->ownerId;
        }

        Contact::insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->database_tag)->dropIfExists('contacts');
    }
};
