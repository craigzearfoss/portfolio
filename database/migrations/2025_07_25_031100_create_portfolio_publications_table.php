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
            $table->tinyInteger('featured')->default(0);
            $table->string('summary')->nullable();
            $table->string('publication_name')->nullable();
            $table->string('publisher')->nullable();
            $table->date('date')->nullable();
            $table->integer('year')->nullable();
            $table->string('credit')->nullable();
            $table->tinyInteger('fiction')->default(0);
            $table->tinyInteger('nonfiction')->default(0);
            $table->tinyInteger('technical')->default(0);
            $table->tinyInteger('research')->default(0);
            $table->tinyInteger('freelance')->default(0);
            $table->tinyInteger('online')->default(0);
            $table->tinyInteger('novel')->default(0);
            $table->tinyInteger('book')->default(0);
            $table->tinyInteger('textbook')->default(0);
            $table->tinyInteger('story')->default(0);
            $table->tinyInteger('article')->default(0);
            $table->tinyInteger('paper')->default(0);
            $table->tinyInteger('pamphlet')->default(0);
            $table->tinyInteger('poetry')->default(0);
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
            $table->tinyInteger('public')->default(1);
            $table->tinyInteger('readonly')->default(0);
            $table->tinyInteger('root')->default(0);
            $table->tinyInteger('disabled')->default(0);
            $table->tinyInteger('demo')->default(0);
            $table->timestamps();
            $table->softDeletes();

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
