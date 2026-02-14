<?php

use App\Models\Portfolio\JobEmploymentType;
use App\Models\Portfolio\JobLocationType;
use App\Models\System\Database;
use App\Models\System\Owner;
use App\Models\System\Resource;
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
     * The id of the admin who owns the portfolio job resource.
     *
     * @var int
     */
    protected $ownerId = 2;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!$database = Database::where('tag', $this->database_tag)->first()) {
            abort(500, 'Database with tag `' . $this->database_tag . '` not found in '
                . config('app.system_db') . '.databases table.');
        }

        if (!$jobResource = Resource::where('database_id', $database->id)->where('table', 'jobs')->first()) {
            abort(500, 'Resource with name `job` not found in ' . config('system_db') . '.resources table.');
        }

        Schema::connection($this->database_tag)->create('jobs', function (Blueprint $table) {

            $systemDbName = Schema::connection('system_db')->getCurrentSchemaName();

            $table->id();
            $table->foreignId('owner_id')
                ->constrained($systemDbName . '.admins', 'id')
                ->onDelete('cascade');
            $table->string('company')->index('company_idx');
            $table->string('role')->index('role_idx');
            $table->string('slug');
            $table->boolean('featured')->default(false);
            $table->string('summary', 500)->nullable();
            $table->integer('start_month')->nullable();
            $table->integer('start_year')->nullable();
            $table->integer('end_month')->nullable();
            $table->integer('end_year')->nullable();
            $table->foreignId('job_employment_type_id')
                ->nullable()
                ->constrained('job_employment_types', 'id')
                ->onDelete('cascade');
            $table->foreignId('job_location_type_id')
                ->nullable()
                ->constrained('job_location_types', 'id')
                ->onDelete('cascade');
            $table->string('street')->nullable();
            $table->string('street2')->nullable();
            $table->string('city', 100)->nullable();
            $table->foreignId('state_id')
                ->nullable()
                ->constrained($systemDbName.'.states', 'id')
                ->onDelete('cascade');
            $table->string('zip', 20)->nullable();
            $table->foreignId('country_id')
                ->nullable()
                ->constrained($systemDbName.'.countries', 'id')
                ->onDelete('cascade');
            $table->float('latitude')->nullable();
            $table->float('longitude')->nullable();
            $table->text('notes')->nullable();
            $table->string('link', 500)->nullable();
            $table->string('link_name')->nullable();
            $table->text('description')->nullable();
            $table->string('disclaimer', 500)->nullable();
            $table->string('image', 500)->nullable();
            $table->string('image_credit')->nullable();
            $table->string('image_source')->nullable();
            $table->string('thumbnail', 500)->nullable();
            $table->string('logo', 500)->nullable();
            $table->string('logo_small', 500)->nullable();
            $table->boolean('public')->default(false);
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
                'owner_id'    => null,
                'company'     => '',
                'role'        => '',
                'slug'        => '',
                'featured'    => 0,
                'summary'     => '',
                'start_month' => null,
                'start_year'  => null,
                'end_month'   => null,
                'end_year'    => null,
                'job_employment_type_id' => 1,
                'job_location_type_id'   => 1,
                'city'        => null,
                'state_id'    => null,
                'country_id'  => null,
                'thumbnail'   => null,
                'public'      => 1,
            ],
        ];

        // add timestamps
        for($i=0; $i<count($data);$i++) {
            $data[$i]['created_at'] = now();
            $data[$i]['updated_at'] = now();
        }

        Job::insert($data);
        */
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->database_tag)->dropIfExists('jobs');
    }
};
