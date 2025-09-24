<?php

use App\Models\Career\Company;
use App\Models\Career\Contact;
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
        Schema::connection('career_db')->create('contacts', function (Blueprint $table) {
            $table->id();
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
            $table->foreignIdFor(\App\Models\Admin::class);
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['admin_id', 'name'], 'admin_id_name_unique');
            $table->unique(['admin_id', 'slug'], 'admin_id_slug_unique');
        });

        $data = [
            [ 'id' => 1,  'name' => 'Chad Vasquez',     'slug' => 'Chad Vasquez',     'phone' => null,	           'phone_label' => null,   'email' => 'Chad.Vasquez@CyberCoders.com',         'email_label' => 'work', 'admin_id' => 2 ],
            [ 'id' => 2,  'name' => 'Lyman Ambrose',    'slug' => 'Lyman Ambrose',    'phone' => null,	           'phone_label' => null,   'email' => 'lyman.ambrose@mondo.com',              'email_label' => 'work', 'admin_id' => 2 ],
            [ 'id' => 3,  'name' => 'Miles Biegert',    'slug' => 'Miles Biegert',    'phone' => null,             'phone_label' => null,   'email' => 'milesb@infinity-cs.com',               'email_label' => 'work', 'admin_id' => 2 ],
            [ 'id' => 4,  'name' => 'Jolly Nibu',       'slug' => 'Jolly Nibu',       'phone' => null,	           'phone_label' => null,   'email' => 'jolly.nibu@artech.com',                'email_label' => 'work', 'admin_id' => 2 ],
            [ 'id' => 5,  'name' => 'Connor Sullivan',  'slug' => 'Connor Sullivan',  'phone' => null,	           'phone_label' => null,   'email' => null,                                   'email_label' => null,   'admin_id' => 2 ],
            [ 'id' => 6,  'name' => 'Jordan Luehmann',  'slug' => 'Jordan Luehmann',  'phone' => null,	           'phone_label' => null,   'email' => 'jluehmann@horizontal.com',             'email_label' => 'work', 'admin_id' => 2 ],
            [ 'id' => 7,  'name' => 'Steve Allen',      'slug' => 'Steve Allen',      'phone' => null,	           'phone_label' => null,   'email' => null,                                   'email_label' => null,   'admin_id' => 2 ],
            [ 'id' => 8,  'name' => 'Victor Fung',      'slug' => 'Victor Fung',      'phone' => null,             'phone_label' => null,   'email' => null,                                   'email_label' => null,   'admin_id' => 2 ],
            [ 'id' => 9,  'name' => 'Jessica Chandler', 'slug' => 'Jessica Chandler', 'phone' => null,             'phone_label' => null,   'email' => null,                                   'email_label' => null,   'admin_id' => 2 ],
            [ 'id' => 10, 'name' => 'Donna Morgan',     'slug' => 'Donna Morgan',     'phone' => null,             'phone_label' => null,   'email' => null,                                   'email_label' => null,   'admin_id' => 2 ],
            [ 'id' => 11, 'name' => 'Kirsten Carlson',  'slug' => 'Kirsten Carlson',  'phone' => null,	           'phone_label' => null,   'email' => null,                                   'email_label' => null,   'admin_id' => 2 ],
            [ 'id' => 12, 'name' => 'Kyle Nussberger',  'slug' => 'Kyle Nussberger',  'phone' => null,	           'phone_label' => null,   'email' => null,                                   'email_label' => null,   'admin_id' => 2 ],
            [ 'id' => 13, 'name' => 'Andrew Jones',     'slug' => 'Andrew Jones',     'phone' => null,	           'phone_label' => null,   'email' => null,                                   'email_label' => null,   'admin_id' => 2 ],
            [ 'id' => 14, 'name' => 'Dylan Rogelstad',  'slug' => 'Dylan Rogelstad',  'phone' => null,	           'phone_label' => null,   'email' => 'dylan.rogelstad@mail.cybercoders.com', 'email_label' => 'work', 'admin_id' => 2 ],
            [ 'id' => 15, 'name' => 'Larry Kraynak',    'slug' => 'Larry Kraynak',    'phone' => null,	           'phone_label' => null,   'email' => null,                                   'email_label' => null,   'admin_id' => 2 ],
            [ 'id' => 16, 'name' => 'Tim Lesnick',      'slug' => 'Tim Lesnick',      'phone' => null,             'phone_label' => null,   'email' => 'tlesnick@trovasearch.com',             'email_label' => 'work', 'admin_id' => 2 ],
            [ 'id' => 17, 'name' => 'Ciara Monahan',    'slug' => 'Ciara Monahan',    'phone' => null,             'phone_label' => null,   'email' => 'Ciara.Monahan@insightglobal.com',      'email_label' => 'work', 'admin_id' => 2 ],
            [ 'id' => 18, 'name' => 'Rob Neylon',       'slug' => 'Rob Neylon',       'phone' => null,	           'phone_label' => null,   'email' => 'rob@yscouts.com',                      'email_label' => 'work', 'admin_id' => 2 ],
            [ 'id' => 19, 'name' => 'Billy Bisson',     'slug' => 'Billy Bisson',     'phone' => null,	           'phone_label' => null,   'email' => null,                                   'email_label' => null,   'admin_id' => 2 ],
            [ 'id' => 20, 'name' => 'Kelsey Higgins',   'slug' => 'Kelsey Higgins',   'phone' => '(774) 283-1614', 'phone_label' => 'work', 'email' => 'kelsey.higgins@klaviyo.com',           'email_label' => 'work', 'admin_id' => 2 ],
            [ 'id' => 21, 'name' => 'Britney Coleman',  'slug' => 'Britney Coleman',  'phone' => null,	           'phone_label' => null,   'email' => 'coleman@lendflow.io',                  'email_label' => 'work', 'admin_id' => 2 ],
            [ 'id' => 22, 'name' => 'Dan Chaffee',      'slug' => 'Dan Chaffee',      'phone' => null,	           'phone_label' => null,   'email' => null,                                   'email_label' => null,   'admin_id' => 2 ],
            [ 'id' => 23, 'name' => 'Kara Caldwell',    'slug' => 'Kara Caldwell',    'phone' => null,	           'phone_label' => null,   'email' => null,                                   'email_label' => null,   'admin_id' => 2 ],
        ];

        Contact::insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('career_db')->dropIfExists('contacts');
    }
};
