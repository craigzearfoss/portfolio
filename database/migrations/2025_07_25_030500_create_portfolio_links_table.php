<?php

use App\Models\Portfolio\Link;
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
     * The id of the admin who owns the portfolio link resource.
     *
     * @var int
     */
    protected $ownerId = 2;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection($this->database_tag)->create('links', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Owner::class, 'owner_id');
            $table->string('name');
            $table->string('slug');
            $table->tinyInteger('featured')->default(0);
            $table->string('url');
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
            $table->softDeletes();
            $table->timestamps();

            $table->unique(['owner_id', 'name'], 'owner_id_name_unique');
            $table->unique(['owner_id', 'slug'], 'owner_id_slug_unique');
        });

        $data = [
            [
                'id'           => 1,
                'name'         => 'LinkedIn',
                'slug'         => 'linkedin',
                'url'          => 'https://www.linkedin.com/in/craig-zearfoss/',
                'description'  => '',
                'public'       => 1,
                'sequence'     => 0,
            ],
            [
                'id'           => 2,
                'name'         => 'GitHub',
                'slug'         => 'github',
                'url'          => 'https://github.com/craigzearfoss',
                'description'  => '',
                'public'       => 1,
                'sequence'     => 1,
            ],
            [
                'id'           => 3,
                'name'         => 'Facebook',
                'slug'         => 'facebook',
                'url'          => 'https://www.facebook.com/craig.zearfoss',
                'description'  => '',
                'public'       => 1,
                'sequence'     => 2,
            ],
            [
                'id'           => 4,
                'name'         => 'Craig Zearfoss Collection, 1988-2008',
                'slug'         => 'craig-zearfoss-collection-1988-2008',
                'url'          => 'https://finding-aids.lib.unc.edu/catalog/20509',
                'description'  => 'A publicly available collection of live video recordings, audio recordings, posters, photographs, and papers affiliated with the Triangle\'s indie rock music scene from 1988 to 2008.',
                'public'       => 1,
                'sequence'     => 3,
            ],
        ];

        // add timestamps and owner_ids
        for($i=0; $i<count($data);$i++) {
            $data[$i]['created_at'] = now();
            $data[$i]['updated_at'] = now();
            $data[$i]['owner_id']   = $this->ownerId;
        }

        Link::insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->database_tag)->dropIfExists('links');
    }
};
