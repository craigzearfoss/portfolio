<?php

use App\Models\System\Admin;
use App\Models\System\AdminResource;
use App\Models\System\Database;
use App\Models\System\Resource;
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
    protected string $table_name = 'anti_skills';

    /**
     * @var Admin|null
     */
    protected Admin|null $rootAdmin = null;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $this->rootAdmin = new Admin()->newQuery()->where('username', '=', 'root')->first();

        /** -----------------------------------------------------
         * Create portfolio.anti_skills table.
         ** ----------------------------------------------------- */
        Schema::connection($this->database_tag)->create($this->table_name, function (Blueprint $table) {

            $systemDbName = Schema::connection('system_db')->getCurrentSchemaName();
            $dictionaryDbName = Schema::connection('dictionary_db')->getCurrentSchemaName();

            $table->id();
            $table->foreignId('owner_id')
                ->constrained($systemDbName . '.admins', 'id')
                ->onDelete('cascade');
            $table->string('name')->index('name_idx');
            $table->string('slug')->index('slug_idx');
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

        DB::connection($this->database_tag)->table($this->table_name)->insert($data);
        */

        /** -----------------------------------------------------
         * Add entry to system.resources table.
         ** ----------------------------------------------------- */
        $portfolioDatabase = new Database()->newQuery()->where('tag', '=', 'portfolio_db')->first();

        $skillResource = new Resource()->newQuery()->where('database_id', '=', $portfolioDatabase->id)
            ->where('table_name', 'skills')->first();

        $resourceData = [
            'parent_id'      => null,
            'owner_id'       => $this->rootAdmin->id,
            'database_id'    => $portfolioDatabase->id,
            'name'           => 'anti_skill',
            'table_name'     => 'anti_skills',
            'class'          => 'App\Models\Portfolio\AntiSkill',
            'title'          => 'Anti-Skill',
            'plural'         => 'Anti-Skills',
            'has_owner'      => true,
            'has_user'       => false,
            'guest'          => false,
            'user'           => false,
            'admin'          => true,
            'menu'           => false,
            'menu_level'     => 1,
            'menu_collapsed' => false,
            'icon'           => 'fa-star-o',
            'is_public'      => false,
            'is_readonly'    => false,
            'is_root'        => false,
            'is_disabled'    => false,
            'is_demo'        => false,
            'sequence'       => $skillResource->sequence + 4,
            'created_at'     => now(),
            'updated_at'     => now(),
        ];

        DB::connection('system_db')->table('resources')->insert($resourceData);

        /** -----------------------------------------------------
         * Add entries to system.admin_resources table.
         ** ----------------------------------------------------- */
        $antiSkillResource = new Resource()->newQuery()
            ->where('database_id', '=', $portfolioDatabase->id)
            ->where('table_name', 'anti_skills')->first();

        $skillAdminResourceQuery = new Admin()->newQuery()
            ->select('admin_resources.*')
            ->leftJoin('admin_resources', 'admin_resources.owner_id', '=', 'admins.id')
            ->where('admin_resources.database_id', '=', $skillResource->database_id)
            ->where('admin_resources.name', '=', 'skill');

        foreach ($skillAdminResourceQuery->get() as $skillAdminResource) {

            $antiSkillData = [
                'parent_id'         => null,
                'owner_id'          => $skillAdminResource->owner_id,
                'resource_id'       => $antiSkillResource->id,
                'database_id'       => $antiSkillResource->database_id,
                'admin_database_id' => $skillAdminResource->admin_database_id,
                'name'              => $antiSkillResource->name,
                'table_name'        => $antiSkillResource->table_name,
                'class'             => $antiSkillResource->class,
                'title'             => $antiSkillResource->title,
                'plural'            => $antiSkillResource->plural,
                'has_owner'         => $antiSkillResource->has_owner,
                'has_user'          => $antiSkillResource->has_user,
                'guest'             => $antiSkillResource->guest,
                'user'              => $antiSkillResource->user,
                'admin'             => $antiSkillResource->admin,
                'menu'              => $antiSkillResource->menu,
                'menu_level'        => $antiSkillResource->menu_level,
                'menu_collapsed'    => $antiSkillResource->menu_collapsed,
                'icon'              => $antiSkillResource->icon,
                'is_public'         => $antiSkillResource->is_public,
                'is_readonly'       => $antiSkillResource->is_readonly,
                'is_root'           => $antiSkillResource->is_root,
                'is_disabled'       => $antiSkillResource->is_disabled,
                'is_demo'           => $antiSkillResource->is_demo,
                'sequence'          => $skillAdminResource->sequence + 4,
                'created_at'        => now(),
                'updated_at'        => now(),
            ];

            DB::connection('system_db')->table('admin_resources')->insert($antiSkillData);
        }
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->database_tag)->dropIfExists($this->table_name);
    }
};
