<?php

use App\Models\System\Database;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * The tag used to identify the system database.
     *
     * @var string
     */
    protected $database_tag = 'system_db';

    /**
     * The id of the admin who owns the system database.
     * The admin must have root permissions.
     *
     * @var int
     */
    protected $rootAdminId = 1;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection($this->database_tag)->create('databases', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\System\Owner::class, 'owner_id');
            $table->string('name', 50)->unique();
            $table->string('database', 50)->unique();
            $table->string('tag', 50)->unique();
            $table->string('title', 50);
            $table->string('plural', 50);
            $table->boolean('guest')->default(false);
            $table->boolean('user')->default(false);
            $table->boolean('admin')->default(false);
            $table->boolean('global')->default(false);
            $table->string('icon', 50)->nullable();
            $table->boolean('public')->default(true);
            $table->boolean('readonly')->default(false);
            $table->boolean('root')->default(true);
            $table->boolean('disabled')->default(false);
            $table->boolean('demo')->default(false);
            $table->integer('sequence')->default(false);
            $table->timestamps();
        });

        /** -----------------------------------------------------
         * Add system database.
         ** ----------------------------------------------------- */
        $data = [
            [
                'id'       => 1,
                'name'     => 'system',
                'database' => config('app.' . $this->database_tag),
                'tag'      => 'system_db',
                'title'    => 'System',
                'plural'   => 'Systems',
                'icon'     => 'fa-cog',
                'guest'    => 0,
                'user'     => 0,
                'admin'    => 1,
                'global'   => 0,
                'sequence' => 10000,
                'public'   => 1,
                'disabled' => 0,
            ],
        ];

        // add timestamps and owner_ids
        for($i=0; $i<count($data);$i++) {
            $data[$i]['created_at'] = now();
            $data[$i]['updated_at'] = now();
            $data[$i]['owner_id']   = $this->rootAdminId;
        }

        Database::insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->database_tag)->dropIfExists('databases');
    }
};
