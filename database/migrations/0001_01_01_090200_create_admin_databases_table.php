<?php

use App\Models\System\Admin;
use App\Models\System\AdminDatabase;
use App\Models\System\Database;
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
     * Run the migrations.
     */
    public function up(): void
    {
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
            $table->string('title', 50)->index('title_idx');
            $table->string('plural', 50);
            $table->boolean('has_owner')->default(true);
            $table->boolean('guest')->default(false);
            $table->boolean('user')->default(false);
            $table->boolean('admin')->default(false);
            $table->boolean('menu')->default(false);
            $table->integer('menu_level')->default(1);
            $table->boolean('menu_collapsed')->default(false);
            $table->string('icon', 50)->nullable();
            $table->boolean('is_public')->default(true);
            $table->boolean('is_readonly')->default(false);
            $table->boolean('is_root')->default(false);
            $table->boolean('is_disabled')->default(false);
            $table->boolean('is_demo')->default(false);
            $table->integer('sequence')->default(0);
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
                    'menu'           => $systemDatabase->menu,
                    'menu_level'     => $systemDatabase->menu_level,
                    'menu_collapsed' => $systemDatabase->menu_collapsed,
                    'icon'           => $systemDatabase->icon,
                    'is_public'      => $systemDatabase->is_public,
                    'is_readonly'    => $systemDatabase->is_readonly,
                    'is_root'        => $systemDatabase->is_root,
                    'is_disabled'    => $systemDatabase->is_disabled,
                    'is_demo'        => $systemDatabase->is_demo,
                    'sequence'       => $systemDatabase->sequence,
                ];
            }

            // add timestamps
            for ($i = 0; $i < count($data); $i++) {
                $data[$i]['created_at'] = now();
                $data[$i]['updated_at'] = now();
            }

            new AdminDatabase()->insert($data);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->database_tag)->dropIfExists('admin_databases');
    }

    /**
     * @return array
     */
    private function getAdminIds(): array
    {
        return Admin::all()->pluck('id')->toArray();
    }

    private function getDatabase()
    {
        return new Database()->where('tag', '=', $this->database_tag)->first();
    }
};
