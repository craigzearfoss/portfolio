<?php

use App\Models\System\Database;
use App\Models\System\Owner;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * @var string
     */
    protected string $database_tag = 'system_db';

    /**
     * The id of the admin who owns the system database.
     * The admin must have root permissions.
     *
     * @var int
     */
    protected int $rootAdminId = 1;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection($this->database_tag)->create('databases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('owner_id')
                ->constrained('admins', 'id')
                ->onDelete('cascade');
            $table->string('name', 50)->unique();
            $table->string('database', 50)->unique();
            $table->string('tag', 50)->unique();
            $table->string('title', 50);
            $table->string('plural', 50);
            $table->boolean('has_owner')->default(true);
            $table->boolean('guest')->default(false);
            $table->boolean('user')->default(false);
            $table->boolean('admin')->default(false);
            $table->boolean('menu')->default(false);
            $table->integer('menu_level')->default(1);
            $table->boolean('menu_collapsed')->default(false);
            $table->string('icon', 50)->nullable();
            $table->boolean('public')->default(true);
            $table->boolean('readonly')->default(false);
            $table->boolean('root')->default(false);
            $table->boolean('disabled')->default(false);
            $table->boolean('demo')->default(false);
            $table->integer('sequence')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });

        /** -----------------------------------------------------
         * Add system database.
         ** ----------------------------------------------------- */
        $data = [
            [
                'id'             => 1,
                'name'           => 'system',
                'database'       => config('app.' . $this->database_tag),
                'tag'            => 'system_db',
                'title'          => 'System',
                'plural'         => 'Systems',
                'has_owner'      => true,
                'guest'          => true,
                'user'           => true,
                'admin'          => true,
                'menu'           => true,
                'menu_level'     => 0,
                'menu_collapsed' => true,
                'icon'           => 'fa-cog',
                'public'         => true,
                'readonly'       => false,
                'root'           => false,
                'disabled'       => false,
                'demo'           => 0,
                'sequence'       => 10000,
            ],
        ];

        // add timestamps and owner_ids
        for($i=0; $i<count($data);$i++) {
            $data[$i]['created_at'] = now();
            $data[$i]['updated_at'] = now();
            $data[$i]['owner_id']   = $this->rootAdminId;
        }

        new Database()->insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->database_tag)->dropIfExists('databases');
    }
};
