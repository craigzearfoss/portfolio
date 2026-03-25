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
     * The id of the admin who owns the portfolio publication resource.
     *
     * @var int
     */
    protected int $ownerId = 2;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection($this->database_tag)->create('education', function (Blueprint $table) {

            $systemDbName = Schema::connection('system_db')->getCurrentSchemaName();

            $table->id();
            $table->foreignId('owner_id')
                ->constrained($systemDbName . '.admins', 'id')
                ->onDelete('cascade');
            $table->foreignId('degree_type_id')
                ->constrained('degree_types', 'id')
                ->onDelete('cascade');
            $table->string('major')->index('major_idx');
            $table->string('minor')->nullable()->index('minor_idx');
            $table->foreignId('school_id')
                ->constrained('schools', 'id')
                ->onDelete('cascade');
            $table->string('slug')->index('slug_idx');
            $table->boolean('featured')->default(false);
            $table->string('summary', 500)->nullable();
            $table->integer('enrollment_month')->nullable()->index('enrollment_month_idx');
            $table->integer('enrollment_year')->nullable()->index('enrollment_year_idx');
            $table->boolean('graduated')->default(false);
            $table->integer('graduation_month')->nullable()->index('graduation_month_idx');
            $table->integer('graduation_year')->nullable()->index('graduation_year_idx');
            $table->boolean('currently_enrolled')->default(false);
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

            $table->unique(['owner_id', 'slug'], 'owner_id_slug_unique');
        });

        /*
        $data = [
            [
                'id'          => 1,
                'owner_id     => null
                'title'       => '',
                'slug'        => '',
                'featured'    => 0,
                'parent_id    => null,
                'featured'    => 0,
                'summary'     => null,
                'publication' => null,
                'publisher'   => null,
                'date'        => null,
                'year'        => null,
                'credit'      => null,
                'freelance'   => 0,
                'fiction'     => 0,
                'nonfiction'  => 0,
                'technical'   => 0,
                'research'    => 0,
                'poetry'      => 0,
                'online'      => 0,
                'novel'       => 0,
                'book'        => 0,
                'textbook'    => 0,
                'article'     => 0,
                'paper'       => 0,
                'pamphlet'    => 0,
                'link'        => '',
                'link_name'   => '',
                'description' => '',
                'is_public'   => true,
                'is_readonly' => false,
                'is_root'     => false,
                'is_disabled' => false,
                'is_demo'     => false,
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
