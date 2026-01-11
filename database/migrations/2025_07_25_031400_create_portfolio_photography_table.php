<?php

use App\Models\Portfolio\Photography;
use App\Models\System\Owner;
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
     * The id of the admin who owns the portfolio publication resource.
     *
     * @var int
     */
    protected $ownerId = 2;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection($this->database_tag)->create('photography', function (Blueprint $table) {

            $systemDbName = Schema::connection('system_db')->getCurrentSchemaName();

            $table->id();
            $table->foreignId('owner_id')
                ->constrained($systemDbName . '.admins', 'id')
                ->onDelete('cascade');
            $table->string('name')->index('name_idx');
            $table->string('slug');
            $table->boolean('featured')->default(false);
            $table->string('summary', 500)->nullable();
            $table->integer('year')->nullable();
            $table->string('credit')->nullable();
            $table->string('model')->nullable();
            $table->string('location')->nullable();
            $table->string('photo_url', 500)->nullable();
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
            $table->boolean('public')->default(true);
            $table->boolean('readonly')->default(false);
            $table->boolean('root')->default(false);
            $table->boolean('disabled')->default(false);
            $table->boolean('demo')->default(false);
            $table->integer('sequence')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['owner_id', 'slug'], 'owner_id_slug_unique');
        });

        /*
        $data = [
            [
                'owner_id'       => null,
                'name'           => '',
                'slug'           => '',
                'featured'       => 0,
                'summary'        => null,
                'year'           => null,
                'model'          => null,
                'location'       => null,
                'photo_url'      => null,
                'copyright'      => null,
                'notes'          => null,
                'description'    => '',
                'public'         => 1,
            ]
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
        Schema::connection($this->database_tag)->dropIfExists('photography');
    }
};
