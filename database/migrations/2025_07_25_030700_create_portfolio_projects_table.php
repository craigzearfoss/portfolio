<?php

use App\Models\Portfolio\Project;
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
     * The id of the admin who owns the portfolio project resource.
     *
     * @var int
     */
    protected $ownerId = 2;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection($this->database_tag)->create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Owner::class, 'owner_id');
            $table->string('name');
            $table->string('slug');
            $table->tinyInteger('featured')->default(0);
            $table->string('summary')->nullable();
            $table->year('year')->nullable();
            $table->string('language', 50)->nullable();
            $table->string('language_version', 20)->nullable();
            $table->string('repository_url')->nullable();
            $table->string('repository_name')->nullable();
            $table->string('link')->nullable();
            $table->string('link_name')->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->string('image_credit')->nullable();
            $table->string('image_source')->nullable();
            $table->string('thumbnail')->nullable();
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

        $data = [
            [
                'id'               => 1,
                'name'             => 'Multi-guard Framework',
                'slug'             => 'multi-guard-framework',
                'featured'         => 1,
                'summary'          => null,
                'year'             => 2025,
                'language'         => 'Laravel',
                'language_version' => '12.29',
                'repository_url'   => 'https://github.com/craigzearfoss/laravel-multi-guard',
                'repository_name'  => 'craigzearfoss/laravel-multi-guard',
                'link'             => null,
                'link_name'        => null,
                'description'      => null,
                'sequence'         => 0,
            ],
            [
                'id'               => 2,
                'name'             => 'Portfolio Framework',
                'slug'             => 'portfolio-framework',
                'featured'         => 1,
                'summary'          => null,
                'year'             => 2025,
                'language'         => 'Laravel',
                'language_version' => '12.29',
                'repository_url'   => 'https://github.com/craigzearfoss/portfolio',
                'repository_name'  => 'craigzearfoss/portfolio',
                'link'             => null,
                'link_name'        => null,
                'description'      => null,
                'sequence'         => 0,
            ],
            [
                'id'               => 3,
                'name'             => 'Addressable Trait',
                'slug'             => 'addressable-trait',
                'featured'         => 0,
                'summary'          => null,
                'year'             => 2016,
                'language'         => 'Laravel',
                'language_version' => '5.1',
                'repository_url'   => 'https://github.com/craigzearfoss/addressable-trait',
                'repository_name'  => 'craigzearfoss/addressable-trait',
                'link'             => null,
                'link_name'        => null,
                'description'      => null,
                'sequence'         => 0,
            ],
            [
                'id'               => 4,
                'name'             => 'Speedmon',
                'slug'             => 'speedmon',
                'featured'         => 0,
                'summary'          => null,
                'year'             => 2020,
                'language'         => 'Python',
                'language_version' => '3',
                'repository_url'   => 'https://github.com/craigzearfoss/speedmon',
                'repository_name'  => 'craigzearfoss/speedmon',
                'link'             => null,
                'link_name'        => null,
                'description'      => null,
                'sequence'         => 0,
            ],
        ];

        // add timestamps and owner_ids
        for($i=0; $i<count($data);$i++) {
            $data[$i]['created_at'] = now();
            $data[$i]['updated_at'] = now();
            $data[$i]['owner_id']   = $this->ownerId;
        }

        Project::insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->database_tag)->dropIfExists('projects');
    }
};
