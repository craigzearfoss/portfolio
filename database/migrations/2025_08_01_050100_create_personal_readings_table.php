<?php

use App\Models\Personal\Reading;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * The tag used to identify the personal database.
     *
     * @var string
     */
    protected $database_tag = 'personal_db';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection($this->database_tag)->create('readings', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\System\Owner::class, 'owner_id');
            $table->string('title');
            $table->string('author')->nullable();
            $table->string('slug');
            $table->tinyInteger('featured')->default(0);
            $table->string('summary')->nullable();
            $table->integer('publication_year')->nullable();
            $table->tinyInteger('fiction')->default(0);
            $table->tinyInteger('nonfiction')->default(0);
            $table->tinyInteger('paper')->default(1);
            $table->tinyInteger('audio')->default(0);
            $table->tinyInteger('wishlist')->default(0);
            $table->text('notes')->nullable();
            $table->string('link', 500)->nullable();
            $table->string('link_name')->nullable();
            $table->text('description')->nullable();
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

            $table->unique(['owner_id', 'title', 'author'], 'owner_id_title_author_unique');
            $table->unique(['owner_id', 'slug'], 'owner_id_slug_unique');
        });

        /*
        $data = [
            [
                'id'               => 1,
                'title'            => '',
                'author'           => null,
                'slug'             => '',
                'publication_year' => null,
                'link_name'        => null,
                'link'             => null,
                'fiction'          => 1,
                'nonfiction'       => 0,
                'paper'            => 1,
                'audio'            => 0,
                'wishlist'         => 0,
                'image'            => null
            ]
        ];

        // add timestamps and owner_ids
        for($i=0; $i<count($data);$i++) {
            $data[$i]['created_at'] = now();
            $data[$i]['updated_at'] = now();
            $data[$i]['owner_id']   = null;
        }

        Reading::insert($data);
        */
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->database_tag)->dropIfExists('readings');
    }
};
