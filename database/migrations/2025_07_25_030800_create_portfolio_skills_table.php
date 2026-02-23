<?php

use App\Models\Dictionary\Category;
use App\Models\System\Owner;
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
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection($this->database_tag)->create('skills', function (Blueprint $table) {

            $systemDbName = Schema::connection('system_db')->getCurrentSchemaName();
            $dictionaryDbName = Schema::connection('dictionary_db')->getCurrentSchemaName();

            $table->id();
            $table->foreignId('owner_id')
                ->constrained($systemDbName . '.admins', 'id')
                ->onDelete('cascade');
            $table->string('name')->index('name_idx');
            $table->string('slug');
            $table->string('version', 20)->nullable();
            $table->boolean('featured')->default(false);
            $table->string('summary', 500)->nullable();
            $table->integer('type_id')->default(0);
            $table->tinyInteger('level')->nullable();
            $table->foreignId('dictionary_category_id')
                ->nullable()
                ->constrained($dictionaryDbName . '.categories', 'id')
                ->onDelete('cascade');
            $table->integer('start_year')->nullable();
            $table->integer('end_year')->nullable();
            $table->integer('years')->nullable();
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

            $table->unique(['owner_id', 'name'], 'owner_id_name_unique');
        });

        /*
        $data = [
            [
                'id'                     => 1,
                'owner_id'               => null,
                'name'                   => '',
                'slug'                   => '',
                'version'                => null,
                'dictionary_category_id' => 11,
                'featured'               => 1,
                'level'                  => null,
                'years'                  => null,
                'start_year'             => null,
                'is_public'              => true,
                'is_readonly'            => false,
                'is_root'                => false,
                'is_disabled'            => false,
                'is_demo'                => false,
            ],
        ];

        // add timestamps
        for($i=0; $i<count($data);$i++) {
            $data[$i]['created_at'] = now();
            $data[$i]['updated_at'] = now();
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
