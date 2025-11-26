<?php

use App\Models\Portfolio\Publication;
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
     * The id of the admin who owns the portfolio publication resource.
     *
     * @var int
     */
    protected $ownerId = 2;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection($this->database_tag)->create('publications', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\System\Owner::class, 'owner_id');
            $table->string('title');
            $table->string('slug');
            $table->foreignIdFor(\App\Models\Portfolio\Publication::class, 'parent_id')->nullable();
            $table->boolean('featured')->default(false);
            $table->string('summary')->nullable();
            $table->string('publication_name')->nullable();
            $table->string('publisher')->nullable();
            $table->date('date')->nullable();
            $table->integer('year')->nullable();
            $table->string('credit')->nullable();
            $table->boolean('fiction')->default(false);
            $table->boolean('nonfiction')->default(false);
            $table->boolean('technical')->default(false);
            $table->boolean('research')->default(false);
            $table->boolean('freelance')->default(false);
            $table->boolean('online')->default(false);
            $table->boolean('novel')->default(false);
            $table->boolean('book')->default(false);
            $table->boolean('textbook')->default(false);
            $table->boolean('story')->default(false);
            $table->boolean('article')->default(false);
            $table->boolean('paper')->default(false);
            $table->boolean('pamphlet')->default(false);
            $table->boolean('poetry')->default(false);
            $table->string('publication_url')->nullable();
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
            $table->integer('sequence')->default(0);
            $table->boolean('public')->default(true);
            $table->boolean('readonly')->default(false);
            $table->boolean('root')->default(false);
            $table->boolean('disabled')->default(false);
            $table->boolean('demo')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->index('title_idx');
            $table->index('slug_idx');

            $table->unique(['owner_id', 'title'], 'owner_id_title_unique');
            $table->unique(['owner_id', 'slug'], 'owner_id_slug_unique');
        });

        /*
        $data = [
            [
                'id'             => 1,
                'owner_id        => null
                'title'          => '',
                'slug'           => '',
                'parent_id       => null,
                'featured'       => 0,
                'summary'        => null,
                'publication'    => null,
                'publisher'      => null,
                'date'           => null,
                'year'           => null,
                'credit'         => null,
                'freelance'      => 0,
                'fiction'        => 0,
                'nonfiction'     => 0,
                'technical'      => 0,
                'research'       => 0,
                'poetry'         => 0,
                'online'         => 0,
                'novel'          => 0,
                'book'           => 0,
                'textbook'       => 0,
                'article'        => 0,
                'paper'          => 0,
                'pamphlet'       => 0,
                'link'           => '',
                'link_name'      => '',
                'description'    => '',
                'public'         => 1,
            ],
        ];

        // add timestamps
        for($i=0; $i<count($data);$i++) {
            $data[$i]['created_at'] = now();
            $data[$i]['updated_at'] = now();
        }

        Publication::insert($data);
        */
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->database_tag)->dropIfExists('publications');
    }
};
