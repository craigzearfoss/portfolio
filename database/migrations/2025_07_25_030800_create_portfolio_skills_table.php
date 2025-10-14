<?php

use App\Models\Portfolio\Skill;
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
     * The id of the admin who owns the portfolio skill resource.
     *
     * @var int
     */
    protected $ownerId = 2;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection($this->database_tag)->create('skills', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\System\Owner::class, 'owner_id');
            $table->string('name');
            $table->string('slug');
            $table->string('version', 20)->nullable();
            $table->tinyInteger('featured')->default(0);
            $table->string('summary')->nullable();
            $table->tinyInteger('level')->default(1);
            $table->foreignIdFor(\App\Models\Dictionary\Category::class, 'dictionary_category_id')->nullable();
            $table->integer('start_year')->nullable();
            $table->integer('end_year')->nullable();
            $table->integer('years')->default(0);
            $table->text('notes')->nullable();
            $table->string('link', 500)->nullable();
            $table->string('link_name')->nullable();
            $table->text('description')->nullable();
            $table->string('image', 500)->nullable();
            $table->string('image_credit')->nullable();
            $table->string('image_source')->nullable();
            $table->string('thumbnail', 500)->nullable();
            $table->integer('sequence')->default(0);
            $table->tinyInteger('public')->default(0);
            $table->tinyInteger('readonly')->default(0);
            $table->tinyInteger('root')->default(0);
            $table->tinyInteger('disabled')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['owner_id', 'name'], 'owner_id_name_unique');
        });

        /*
        $data = [
            [
                'id'                     => 1,
                'name'                   => '',
                'slug'                   => '',
                'version'                => null,
                'dictionary_category_id' => 11,
                'featured'               => 1,
                'level'                  => 10,
                'years'                  => 20,
                'start_year'             => null,
                'public'                 => 1
            ],
        ];

        // add timestamps and owner_ids
        for($i=0; $i<count($data);$i++) {
            $data[$i]['created_at'] = now();
            $data[$i]['updated_at'] = now();
            $data[$i]['owner_id']   = $this->ownerId;
        }

        Skill::insert($data);
        */
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->database_tag)->dropIfExists('skills');
    }
};
