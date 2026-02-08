7<?php

use App\Models\System\Admin;
use App\Models\System\AdminDatabase;
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
     * Run the migrations.
     */
    public function up(): void
    {
        $dbName = config('app.' . $this->database_tag);

        Schema::connection($this->database_tag)->create('admin_databases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('owner_id')
                ->constrained('admins', 'id')
                ->onDelete('cascade');
            $table->foreignId('database_id')
                ->constrained('databases', 'id')
                ->onDelete('cascade');
            $table->string('name', 50)->index('name_idx');
            $table->string('database', 50)->index('database_idx');
            $table->string('tag', 50)->index('tag_idx');
            $table->string('title', 50);
            $table->string('plural', 50);
            $table->boolean('has_owner')->default(true);
            $table->boolean('guest')->default(false);
            $table->boolean('user')->default(false);
            $table->boolean('admin')->default(false);
            $table->boolean('global')->default(false);
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

            $table->unique(['owner_id', 'database_id'], 'owner_id_database_id_unique');
            $table->unique(['owner_id', 'name'], 'owner_id_name_unique');
            $table->unique(['owner_id', 'database'], 'owner_id_database_unique');
            $table->unique(['owner_id', 'tag'], 'owner_id_tag_unique');
        });

        $ownerIds = $this->getAdminIds();
        $systemDatabase = $this->getDatabase();

        if (!empty($ownerIds) && !empty($systemDatabase)) {

            $data = [];

            foreach ($ownerIds as $ownerId) {
                $data[] = [
                    'owner_id'       => $ownerId,
                    'database_id'    => $systemDatabase->id,
                    'name'           => $systemDatabase->name,
                    'database'       => $systemDatabase->database,
                    'tag'            => $systemDatabase->tag,
                    'title'          => $systemDatabase->title,
                    'plural'         => $systemDatabase->plural,
                    'guest'          => $systemDatabase->guest,
                    'user'           => $systemDatabase->user,
                    'admin'          => $systemDatabase->admin,
                    'global'         => $systemDatabase->global,
                    'menu'           => $systemDatabase->menu,
                    'menu_level'     => $systemDatabase->menu_level,
                    'menu_collapsed' => $systemDatabase->menu_collapsed,
                    'icon'           => $systemDatabase->icon,
                    'public'         => $systemDatabase->public,
                    'readonly'       => $systemDatabase->readonly,
                    'root'           => $systemDatabase->root,
                    'disabled'       => $systemDatabase->disabled,
                    'demo'           => $systemDatabase->demo,
                    'sequence'       => $systemDatabase->sequence,
                ];
            }

            // add timestamps
            for ($i = 0; $i < count($data); $i++) {
                $data[$i]['created_at'] = now();
                $data[$i]['updated_at'] = now();
            }

            AdminDatabase::insert($data);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->database_tag)->dropIfExists('admin_databases');
    }

    private function getAdminIds()
    {
        return Admin::all()->pluck('id')->toArray();
    }

    private function getDatabase()
    {
        return Database::where('tag', $this->database_tag)->first();
    }
};
