<?php

use App\Models\Personal\Recipe;
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
        Schema::connection($this->database_tag)->create('recipes', function (Blueprint $table) {

            $systemDbName = Schema::connection('system_db')->getCurrentSchemaName();

            $table->id();
            $table->foreignId('owner_id')
                ->constrained($systemDbName . '.admins', 'id')
                ->onDelete('cascade');
            $table->string('name')->index('name_idx');
            $table->string('slug');
            $table->boolean('featured')->default(false);
            $table->string('summary', 500)->nullable();
            $table->string('source')->nullable();
            $table->string('author')->nullable();
            $table->integer('prep_time')->nullable();
            $table->integer('total_time')->nullable();
            $table->integer('main')->default(0);
            $table->integer('side')->default(0);
            $table->integer('dessert')->default(0);
            $table->integer('appetizer')->default(0);
            $table->integer('beverage')->default(0);
            $table->integer('breakfast')->default(0);
            $table->integer('lunch')->default(0);
            $table->integer('dinner')->default(0);
            $table->integer('snack')->default(0);
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

            $table->unique(['owner_id', 'name'], 'owner_id_name_unique');
            $table->unique(['owner_id', 'slug'], 'owner_id_slug_unique');
        });

        /*
        $data = [
            'id'            => 1,
            'name'          => '',
            'slug'          => '',
            'source'        => null,
            'author'        => null,
            'main'          => 0,
            'side'          => 1,
            'dessert'       => 0,
            'appetizer'     => 0,
            'beverage'      => 0,
            'breakfast'     => 0,
            'lunch'         => 1,
            'dinner'        => 1,
            'snack'         => 0,
            'link'          => '',
        ];

        // add timestamps and owner_ids
        for($i=0; $i<count($data);$i++) {
            $data[$i]['created_at'] = now();
            $data[$i]['updated_at'] = now();
            $data[$i]['owner_id']   = null;
        }

        Recipe::insert($data);
        */
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->database_tag)->dropIfExists('recipes');
    }
};
