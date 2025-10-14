<?php

use App\Models\Portfolio\Course;
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
     * The id of the admin who owns the portfolio course resource.
     *
     * @var int
     */
    protected $ownerId = 2;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection($this->database_tag)->create('courses', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\System\Owner::class, 'owner_id');
            $table->string('name');
            $table->string('slug');
            $table->tinyInteger('featured')->default(0);
            $table->string('summary')->nullable();
            $table->year('year')->nullable()->default(null);
            $table->tinyInteger('completed')->default(0);
            $table->date('completion_date')->nullable();
            $table->float('duration_hours')->nullable();
            $table->foreignIdFor( \App\Models\Portfolio\Academy::class)->nullable()->default(null);
            $table->string('school')->nullable()->default(null);
            $table->string('instructor')->nullable()->default(null);
            $table->string('sponsor')->nullable()->default(null);
            $table->string('certificate_url', 500)->nullable();
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
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['owner_id', 'name'], 'owner_id_name_unique');
            $table->unique(['owner_id', 'slug'], 'owner_id_slug_unique');
        });

        /*
        $data = [
            [
                'id'              => 1,
                'name'            => '',
                'slug'            => '',
                'completed'       => 1,
                'completion_date' => null,
                'year'            => 2000,
                'duration_hours'  => 0,
                'academy_id'      => 2,
                'instructor'      => '',
                'sponsor'         => '',
                'certificate_url' => '',
                'link'            => null,
                'link_name'       => null,
            ],
        ];

        // add timestamps and owner_ids
        for($i=0; $i<count($data);$i++) {
            $data[$i]['owner_id']   = $this->ownerId;
            $data[$i]['created_at'] = now();
            $data[$i]['updated_at'] = now();
        }

        Course::insert($data);
        */
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->database_tag)->dropIfExists('courses');
    }
};
