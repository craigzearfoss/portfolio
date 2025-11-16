<?php

use App\Models\Portfolio\Music;
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
        Schema::connection($this->database_tag)->create('music', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\System\Owner::class, 'owner_id');
            $table->foreignIdFor(\App\Models\Portfolio\Video::class, 'parent_id')->nullable();
            $table->string('name');
            $table->string('artist')->nullable();
            $table->string('slug');
            $table->tinyInteger('featured')->default(0);
            $table->string('summary')->nullable();
            $table->tinyInteger('collection')->default(1);
            $table->tinyInteger('track')->default(1);
            $table->string('label')->nullable();
            $table->string('catalog_number', 50)->nullable();
            $table->integer('year')->nullable();
            $table->date('release_date')->nullable();
            $table->text('embed')->nullable();
            $table->string('audio_url')->nullable();
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
            $table->tinyInteger('public')->default(1);
            $table->tinyInteger('readonly')->default(0);
            $table->tinyInteger('root')->default(0);
            $table->tinyInteger('disabled')->default(0);
            $table->tinyInteger('demo')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['owner_id', 'name', 'artist'], 'owner_id_name_artist_unique');
            $table->unique(['owner_id', 'slug'], 'owner_id_slug_unique');
        });

        /*
        $data = [
            [
                'id'             => 1,
                'owner_id'       => null,
                'parent_id'      => null,
                'name'           => '',
                'artist'         => null,
                'slug'           => '',
                'featured'       => 0,
                'summary'        => null,
                'collection'     => 0,
                'track'          => null,
                'label'          => null,
                'catalog_number' => null,
                'year'           => null,
                'embed'          => null,
                'audio_url'      => null,
                'link'           => null,
                'link_name'      => null,
                'description'    => null,
                'image'          => null,
                'sequence'       => 1,
                'public'         => 1,
            ],
        ];

        // add timestamps
        for($i=0; $i<count($data);$i++) {
            $data[$i]['created_at'] = now();
            $data[$i]['updated_at'] = now();
        }

        Music::insert($data);
        */
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->database_tag)->dropIfExists('music');
    }
};
