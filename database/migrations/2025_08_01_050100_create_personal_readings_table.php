<?php

use App\Models\Personal\Reading;
use App\Models\System\Owner;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * @var string
     */
    protected string $database_tag = 'personal_db';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection($this->database_tag)->create('readings', function (Blueprint $table) {

            $systemDbName = Schema::connection('system_db')->getCurrentSchemaName();

            $table->id();
            $table->foreignId('owner_id')
                ->constrained($systemDbName . '.admins', 'id')
                ->onDelete('cascade');
            $table->string('title')->index('title_idx');
            $table->string('author')->nullable()->index('author_idx');
            $table->string('slug');
            $table->boolean('featured')->default(false);
            $table->string('summary', 500)->nullable();
            $table->integer('publication_year')->nullable();
            $table->boolean('fiction')->default(false);
            $table->boolean('nonfiction')->default(false);
            $table->boolean('paper')->default(true);
            $table->boolean('audio')->default(false);
            $table->boolean('wishlist')->default(false);
            $table->text('notes')->nullable();
            $table->string('link', 500)->nullable();
            $table->string('link_name')->nullable();
            $table->text('description')->nullable();
            $table->string('disclaimer', 500)->nullable();
            $table->string('image', 500)->nullable();
            $table->string('image_credit')->nullable();
            $table->string('image_source')->nullable();
            $table->string('thumbnail', 500)->nullable();
            $table->boolean('public')->default(true);
            $table->boolean('readonly')->default(false);
            $table->boolean('root')->default(false);
            $table->boolean('disabled')->default(false);
            $table->boolean('demo')->default(false);
            $table->integer('sequence')->default(false);
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
