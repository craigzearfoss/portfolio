<?php

use App\Models\Portfolio\Video;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * The tag used to identify the portfolio database.
     *
     * @var string
     */
    protected $database_tag = 'portfolio_db';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection($this->database_tag)->create('videos', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\System\Owner::class, 'owner_id');
            $table->string('name')->index('name_idx');
            $table->string('slug');
            $table->foreignIdFor(\App\Models\Portfolio\Video::class, 'parent_id')->nullable();
            $table->boolean('featured')->default(false);
            $table->string('summary')->nullable();
            $table->boolean('full_episode')->default(false);
            $table->boolean('clip')->default(false);
            $table->boolean('public_access')->default(false);
            $table->boolean('source_recording')->default(false);
            $table->date('date')->nullable();
            $table->integer('year')->nullable();
            $table->string('company')->nullable();
            $table->string('credit')->nullable();
            $table->string('show')->nullable();
            $table->string('location')->nullable();
            $table->text('embed')->nullable();
            $table->string('video_url')->nullable();
            $table->string('review_link1`', 500)->nullable();
            $table->string('review_link1_name')->nullable();
            $table->string('review_link2`', 500)->nullable();
            $table->string('review_link2_name')->nullable();
            $table->string('review_link3`', 500)->nullable();
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
            $table->boolean('public')->default(true);
            $table->boolean('readonly')->default(false);
            $table->boolean('root')->default(false);
            $table->boolean('disabled')->default(false);
            $table->boolean('demo')->default(false);
            $table->integer('sequence')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['owner_id', 'name'], 'owner_id_name_unique');
            $table->unique(['owner_id', 'slug'], 'owner_id_slug_unique');
        });

        /*
        $data = [
            [
                'id'                 => 1,
                'ower_id'            => null,
                'name'               => '',
                'slug'               => '',
                'featured'           => 0,
                'summary'            => null,
                'full_episode'       => 0,
                'clip'               => 0,
                'public_access'      => 0,
                'source_recording'   => 0,
                'year'               => 2025,
                'company'            => '',
                'credit'             => '',
                'show'               => null,
                'location'           => '',
                'embed'              => '',
                'link'               => '',
                'link_name'          => '',
                'description'        => '',
                'public'             => 1,
            ],
        ];

        // add timestamps
        for($i=0; $i<count($data);$i++) {
            $data[$i]['created_at'] = now();
            $data[$i]['updated_at'] = now();
        }

        Video::insert($data);
        */
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->database_tag)->dropIfExists('videos');
    }
};
