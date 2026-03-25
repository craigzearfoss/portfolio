<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * @var string
     */
    protected string $database_tag = 'portfolio_db';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection($this->database_tag)->create('audios', function (Blueprint $table) {

            $systemDbName = Schema::connection('system_db')->getCurrentSchemaName();

            $table->id();
            $table->foreignId('parent_id')
                ->nullable()
                ->constrained('audios', 'id')
                ->onDelete('cascade');
            $table->foreignId('owner_id')
                ->constrained($systemDbName . '.admins', 'id')
                ->onDelete('cascade');
            $table->string('name')->index('name_idx');
            $table->string('slug')->index('slug_idx');
            $table->boolean('featured')->default(false);
            $table->string('summary', 500)->nullable();
            $table->boolean('full_episode')->default(false);
            $table->boolean('clip')->default(false);
            $table->boolean('podcast')->default(false);
            $table->boolean('source_recording')->default(false);
            $table->date('date')->nullable()->index('date_idx');
            $table->integer('year')->nullable()->index('year_idx');
            $table->string('company')->nullable()->index('company_idx');
            $table->string('credit')->nullable()->index('credit_idx');
            $table->string('show')->nullable()->index('show_idx');
            $table->string('location')->nullable()->index('location_idx');
            $table->text('embed')->nullable();
            $table->string('audio_url')->nullable();
            $table->string('review_link1', 500)->nullable();
            $table->string('review_link1_name')->nullable();
            $table->string('review_link2', 500)->nullable();
            $table->string('review_link2_name')->nullable();
            $table->string('review_link3', 500)->nullable();
            $table->string('review_link3_name')->nullable();
            $table->text('notes')->nullable();
            $table->string('link', 500)->nullable();
            $table->string('link_name')->nullable();
            $table->text('description')->nullable();
            $table->string('disclaimer', 500)->nullable();
            $table->string('image', 500)->nullable();
            $table->string('image_credit')->nullable();
            $table->string('image_source')->nullable();
            $table->string('thumbnail', 500)->nullable();
            $table->boolean('is_public')->default(true);
            $table->boolean('is_readonly')->default(false);
            $table->boolean('is_root')->default(false);
            $table->boolean('is_disabled')->default(false);
            $table->boolean('is_demo')->default(false);
            $table->integer('sequence')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['owner_id', 'name'], 'owner_id_name_unique');
            $table->unique(['owner_id', 'slug'], 'owner_id_slug_unique');
        });

        /*
        $data = [
            [
                'id'               => 1,
                'owner_id'         => null,
                'name'             => '',
                'slug'             => '',
                'featured'         => 0,
                'summary'          => null,
                'full_episode'     => 0,
                'clip'             => 0,
                'public_access'    => 0,
                'source_recording' => 0,
                'year'             => 2025,
                'company'          => '',
                'credit'           => '',
                'show'             => null,
                'location'         => '',
                'embed'            => '',
                'link'             => '',
                'link_name'        => '',
                'description'      => '',
                'is_public'        => true,
                'is_readonly'      => false,
                'is_root'          => false,
                'is_disabled'      => false,
                'is_demo'          => false,
            ],
        ];

        // add timestamps
        for($i=0; $i<count($data);$i++) {
            $data[$i]['created_at'] = now();
            $data[$i]['updated_at'] = now();
        }

        Audio::insert($data);
        */
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->database_tag)->dropIfExists('audios');
    }
};
