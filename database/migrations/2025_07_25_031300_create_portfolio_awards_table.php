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
    protected string $table_name = 'awards';

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
            $table->string('slug')->nullable()->index('slug_idx');
            $table->boolean('featured')->default(false);
            $table->string('summary', 500)->nullable();
            $table->string('category')->nullable()->index('category_idx');
            $table->string('nominated_work')->nullable()->index('nominated_work_idx');
            $table->integer('award_year')->nullable()->index('award_year_idx');
            $table->date('received')->nullable()->index('received_idx');
            $table->string('organization')->nullable()->index('organization_idx');
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
                'name'           => '',
                'slug'           => '',
                'category'       => null,
                'nominated_work' => null,
                'featured'       => 0,
                'summary'        => null,
                'award_year'     => null,
                'received'       => null,
                'organization'   => null,
                'notes'          => null,
                'description'    => '',
                'is_public'      => true,
                'is_readonly'    => false,
                'is_root'        => false,
                'is_disabled'    => false,
                'is_demo'        => false,
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
