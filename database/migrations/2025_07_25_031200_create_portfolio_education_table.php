<?php

use App\Models\Portfolio\Education;
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
        Schema::connection($this->database_tag)->create('education', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\System\Owner::class, 'owner_id');
            $table->foreignIdFor(\App\Models\Portfolio\DegreeType::class, 'degree_type_id');
            $table->string('major');
            $table->string('minor')->nullable();
            $table->string('slug');
            $table->foreignIdFor(\App\Models\Portfolio\School::class, 'school_id');
            $table->tinyInteger('currently_enrolled')->default(0);
            $table->tinyInteger('completed')->default(0);
            $table->integer('start_month')->nullable();
            $table->integer('start_year')->nullable();
            $table->integer('completion_month')->nullable();
            $table->integer('completion_year')->nullable();
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

        Education::insert($data);
        */
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->database_tag)->dropIfExists('education');
    }
};
