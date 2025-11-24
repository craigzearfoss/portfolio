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
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection($this->database_tag)->create('references', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\System\Owner::class, 'owner_id');
            $table->string('name');
            $table->string('slug');
            $table->boolean('friend')->default(false);
            $table->boolean('family')->default(false);
            $table->boolean('coworker')->default(false);
            $table->boolean('supervisor')->default(false);
            $table->boolean('subordinate')->default(false);
            $table->boolean('professional')->default(false);
            $table->boolean('other')->default(false);
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
            $table->text('notes')->nullable();
            $table->string('link', 500)->nullable();
            $table->string('link_name')->nullable();
            $table->text('description')->nullable();
            $table->string('disclaimer', 500)->nullable();
            $table->string('image', 500)->nullable();
            $table->string('image_credit')->nullable();
            $table->string('image_source')->nullable();
            $table->string('thumbnail', 500)->nullable();
            $table->integer('sequence')->default(0);
            $table->boolean('public')->default(false);
            $table->boolean('readonly')->default(false);
            $table->boolean('root')->default(false);
            $table->boolean('disabled')->default(false);
            $table->boolean('demo')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['owner_id', 'name'], 'owner_id_name_unique');
            $table->unique(['owner_id', 'slug'], 'owner_id_slug_unique');
        });

        /*
        $data = [
            [
                'id'              => 1,
                'owner_id'        => null,
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
        ];

        // add timestamps
        for($i=0; $i<count($data);$i++) {
            $data[$i]['created_at'] = now();
            $data[$i]['updated_at'] = now();
        }

        Reference::insert($data);
        */
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->database_tag)->dropIfExists('references');
    }
};
