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
     * @var string
     */
    protected string $table_name = 'photography';

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
        Schema::connection($this->database_tag)->create($this->table_name, function (Blueprint $table) {

            $systemDbName = Schema::connection('system_db')->getCurrentSchemaName();

            $table->id();
            $table->foreignId('owner_id')
                ->constrained($systemDbName . '.admins', 'id')
                ->onDelete('cascade');
            $table->string('name')->index('name_idx');
            $table->string('slug')->index('slug_idx');
            $table->boolean('featured')->default(false);
            $table->string('summary', 500)->nullable();
            $table->integer('photo_year')->nullable()->index('photo_year_idx');
            $table->string('credit')->nullable()->index('credit_idx');
            $table->string('model')->nullable()->index('model_idx');
            $table->string('location')->nullable()->index('location_idx');
            $table->string('copyright')->nullable();
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
                'owner_id'    => null,
                'name'        => '',
                'slug'        => '',
                'featured'    => 0,
                'summary'     => null,
                'photo_year'  => null,
                'model'       => null,
                'location'    => null,
                'copyright'   => null,
                'notes'       => null,
                'description' => '',
                'image'       => null,
                'is_public'   => true,
                'is_readonly' => false,
                'is_root'     => false,
                'is_disabled' => false,
                'is_demo'     => false,
            ]
        ];

        // add timestamps
        for($i=0; $i<count($data);$i++) {
            $data[$i]['created_at'] = now();
            $data[$i]['updated_at'] = now();
        }

        DB::connection($this->database_tag)->table($this->table_name)->insert($data);
        */
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->database_tag)->dropIfExists($this->table_name);
    }
};
