<?php

use App\Models\Scopes\AdminPublicScope;
use App\Models\System\Database;
use App\Models\System\Resource;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * @var string
     */
    protected string $database_tag = 'portfolio_db';

    /**
     * The id of the admin who owns the portfolio database and resources.
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
        $dbName = config('app.' . $this->database_tag);

        if (empty($dbName)) {
            abort(500, 'app.'.$this->database_tag.' not defined in config\app.php file '
                . ' or PORTFOLIO_DB_DATABASE not defined in .env file.');
        }

        if (empty(DB::select("SHOW DATABASES LIKE '$dbName'"))) {
            abort(500, "Database `$dbName` does not exist.");
        }

        //@TODO: Check if the database or and of the resources exist in the databases or resources tables.

        /** -----------------------------------------------------
         * Add portfolio database.
         ** ----------------------------------------------------- */
        $data = [
            [
                //'id'         => 3,
                'name'       => 'portfolio',
                'database'   => config('app.' . $this->database_tag),
                'tag'        => $this->database_tag,
                'title'      => 'Portfolio',
                'plural'     => 'Portfolios',
                'guest'      => true,
                'user'       => true,
                'admin'      => true,
                'global'     => true,
                'menu'       => true,
                'menu_level' => 0,
                'icon'       => 'fa-folder',
                'public'     => true,
                'root'       => false,
                'disabled'   => false,
                'sequence'   => 1000,
            ],
        ];

        // add timestamps and owner_ids
        for($i=0; $i<count($data);$i++) {
            $data[$i]['created_at'] = now();
            $data[$i]['updated_at'] = now();
            $data[$i]['owner_id']   = $this->rootAdminId;
        }

        $databaseModel = new Database();

        $databaseModel->insert($data);

        if (!$database = $databaseModel->where('database', $dbName)->first()) {

            abort(500, $dbName . 'database not found.');

        } else {

            /** -----------------------------------------------------
             * Add portfolio resources.
             ** ----------------------------------------------------- */
            $resourceModel = new Resource();

            // Note that the parent id refers to the id from the resource table, of the resource_id frm the admin_resources table.
            $resourceId = $resourceModel->withoutGlobalScope(AdminPublicScope::class)->max('id') + 1;

            $jobResourceId = null;

            $data = [];

            $data[] = [
                'id'          => $resourceId++,
                'parent_id'   => null,
                'database_id' => $database->id,
                'name'        => 'academy',
                'table'       => 'academies',
                'class'       => 'App\Models\Portfolio\Academy',
                'title'       => 'Academy',
                'plural'      => 'Academies',
                'has_owner'   => false,
                'guest'       => true,
                'user'        => true,
                'admin'       => true,
                'global'      => true,
                'menu'        => false,
                'menu_level'  => 1,
                'icon'        => 'fa-school',
                'public'      => true,
                'readonly'    => false,
                'root'        => false,
                'disabled'    => false,
                'sequence'    => $database->sequence + 10,
            ];

            $data[] = [
                'id'          => $resourceId++,
                'parent_id'   => null,
                'database_id' => $database->id,
                'name'        => 'art',
                'table'       => 'art',
                'class'       => 'App\Models\Portfolio\Art',
                'title'       => 'Art',
                'plural'      => 'Art',
                'has_owner'   => true,
                'guest'       => true,
                'user'        => true,
                'admin'       => true,
                'global'      => true,
                'menu'        => true,
                'menu_level'  => 1,
                'icon'        => 'fa-image',
                'public'      => true,
                'readonly'    => false,
                'root'        => false,
                'disabled'    => false,
                'sequence'    => $database->sequence + 20,
            ];

            $data[] = [
                'id'          => $resourceId++,
                'parent_id'   => null,
                'database_id' => $database->id,
                'name'        => 'audio',
                'table'       => 'audios',
                'class'       => 'App\Models\Portfolio\Audio',
                'title'       => 'Audio',
                'plural'      => 'Audio',
                'has_owner'   => true,
                'guest'       => true,
                'user'        => true,
                'admin'       => true,
                'global'      => true,
                'menu'        => true,
                'menu_level'  => 1,
                'icon'        => 'fa-microphone',
                'public'      => true,
                'readonly'    => false,
                'root'        => false,
                'disabled'    => false,
                'sequence'    => $database->sequence + 30,
            ];

            $data[] = [
                'id'          => $resourceId++,
                'parent_id'   => null,
                'database_id' => $database->id,
                'name'        => 'award',
                'table'       => 'awards',
                'class'       => 'App\Models\Portfolio\Award',
                'title'       => 'Award',
                'plural'      => 'Awards',
                'has_owner'   => true,
                'guest'       => true,
                'user'        => true,
                'admin'       => true,
                'global'      => true,
                'menu'        => true,
                'menu_level'  => 1,
                'icon'        => 'fa-trophy',
                'public'      => true,
                'readonly'    => false,
                'root'        => false,
                'disabled'    => false,
                'sequence'    => $database->sequence + 40,
            ];

            $data[] = [
                'id'          => $resourceId++,
                'parent_id'   => null,
                'database_id' => $database->id,
                'name'        => 'certificate',
                'table'       => 'certificates',
                'class'       => 'App\Models\Portfolio\Certificate',
                'title'       => 'Certificate',
                'plural'      => 'Certificates',
                'has_owner'   => true,
                'guest'       => true,
                'user'        => true,
                'admin'       => true,
                'global'      => true,
                'menu'        => true,
                'menu_level'  => 1,
                'icon'        => 'fa-thumbs-up',
                'public'      => true,
                'readonly'    => false,
                'root'        => false,
                'disabled'    => false,
                'sequence'    => $database->sequence + 50,
            ];

            $data[] = [
                'id'          => $resourceId++,
                'parent_id'   => null,
                'database_id' => $database->id,
                'name'        => 'certification',
                'table'       => 'certifications',
                'class'       => 'App\Models\Portfolio\Certification',
                'title'       => 'Certification',
                'plural'      => 'Certifications',
                'has_owner'   => false,
                'guest'       => true,
                'user'        => true,
                'admin'       => true,
                'global'      => true,
                'menu'        => false,
                'menu_level'  => 1,
                'icon'        => 'fa-certificate',
                'public'      => true,
                'readonly'    => false,
                'root'        => false,
                'disabled'    => false,
                'sequence'    => $database->sequence + 60,
            ];

            $data[] = [
                'id'          => $resourceId++,
                'parent_id'   => null,
                'database_id' => $database->id,
                'name'        => 'course',
                'table'       => 'courses',
                'class'       => 'App\Models\Portfolio\Course',
                'title'       => 'Course',
                'plural'      => 'Courses',
                'has_owner'   => true,
                'guest'       => true,
                'user'        => true,
                'admin'       => true,
                'global'      => true,
                'menu'        => true,
                'menu_level'  => 1,
                'icon'        => 'fa-chalkboard',
                'public'      => true,
                'readonly'    => false,
                'root'        => false,
                'disabled'    => false,
                'sequence'    => $database->sequence + 70,
            ];

            $data[] = [
                'id'          => $resourceId++,
                'parent_id'   => null,
                'database_id' => $database->id,
                'name'        => 'education',
                'table'       => 'education',
                'class'       => 'App\Models\Portfolio\Education',
                'title'       => 'Education',
                'plural'      => 'Education',
                'has_owner'   => true,
                'guest'       => true,
                'user'        => true,
                'admin'       => true,
                'global'      => true,
                'menu'        => true,
                'menu_level'  => 1,
                'icon'        => 'fa-graduation-cap',
                'public'      => true,
                'readonly'    => false,
                'root'        => false,
                'disabled'    => false,
                'sequence'    => $database->sequence + 80,
            ];

            $jobResourceId = $resourceId;
            $data[] = [
                'id'          => $resourceId++,
                'parent_id'   => null,
                'database_id' => $database->id,
                'name'        => 'job',
                'table'       => 'jobs',
                'class'       => 'App\Models\Portfolio\Job',
                'title'       => 'Job',
                'plural'      => 'Jobs',
                'has_owner'   => true,
                'guest'       => true,
                'user'        => true,
                'admin'       => true,
                'global'      => true,
                'menu'        => true,
                'menu_level'  => 1,
                'icon'        => 'fa-briefcase',
                'public'      => true,
                'readonly'    => false,
                'root'        => false,
                'disabled'    => false,
                'sequence'    => $database->sequence + 90,
            ];

            $data[] = [
                'id'          => $resourceId++,
                'parent_id'   => $jobResourceId,
                'database_id' => $database->id,
                'name'        => 'job-coworker',
                'table'       => 'job_coworkers',
                'class'       => 'App\Models\Portfolio\JobCoworker',
                'title'       => 'Job Coworker',
                'plural'      => 'Job Coworkers',
                'has_owner'   => true,
                'guest'       => false,
                'user'        => false,
                'admin'       => true,
                'global'      => false,
                'menu'        => false,
                'menu_level'  => 2,
                'icon'        => 'fa-users',
                'public'      => true,
                'readonly'    => false,
                'root'        => false,
                'disabled'    => false,
                'sequence'    => $database->sequence + 100,
            ];

            $data[] = [
                'id'          => $resourceId++,
                'parent_id'   => $jobResourceId,
                'database_id' => $database->id,
                'name'        => 'job-skill',
                'table'       => 'job_skills',
                'class'       => 'App\Models\Portfolio\JobSkill',
                'title'       => 'Job Skill',
                'plural'      => 'Job Skills',
                'has_owner'   => true,
                'guest'       => false,
                'user'        => false,
                'admin'       => true,
                'global'      => false,
                'menu'        => false,
                'menu_level'  => 2,
                'icon'        => 'fa-star',
                'public'      => true,
                'readonly'    => false,
                'root'        => false,
                'disabled'    => false,
                'sequence'    => $database->sequence + 110,
            ];

            $data[] = [
                'id'          => $resourceId++,
                'parent_id'   => $jobResourceId,
                'database_id' => $database->id,
                'name'        => 'job-task',
                'table'       => 'job_tasks',
                'class'       => 'App\Models\Portfolio\JobTask',
                'title'       => 'Job Task',
                'plural'      => 'Job Tasks',
                'has_owner'   => true,
                'guest'       => false,
                'user'        => false,
                'admin'       => true,
                'global'      => false,
                'menu'        => false,
                'menu_level'  => 2,
                'icon'        => 'fa-cogs',
                'public'      => true,
                'readonly'    => false,
                'root'        => false,
                'disabled'    => false,
                'sequence'    => $database->sequence + 120,
            ];

            $data[] = [
                'id'          => $resourceId++,
                'parent_id'   => null,
                'database_id' => $database->id,
                'name'        => 'link',
                'table'       => 'links',
                'class'       => 'App\Models\Portfolio\Link',
                'title'       => 'Link',
                'plural'      => 'Links',
                'has_owner'   => true,
                'guest'       => true,
                'user'        => true,
                'admin'       => true,
                'global'      => true,
                'menu'        => true,
                'menu_level'  => 1,
                'icon'        => 'fa-link',
                'sequence'    => $database->sequence + 130,
                'public'      => true,
                'readonly'    => false,
                'root'        => false,
                'disabled'    => false,
            ];

            $data[] = [
                'id'          => $resourceId++,
                'parent_id'   => null,
                'database_id' => $database->id,
                'name'        => 'music',
                'table'       => 'music',
                'class'       => 'App\Models\Portfolio\Music',
                'title'       => 'Music',
                'plural'      => 'Music',
                'has_owner'   => true,
                'guest'       => true,
                'user'        => true,
                'admin'       => true,
                'global'      => true,
                'menu'        => true,
                'menu_level'  => 1,
                'icon'        => 'fa-music',
                'public'      => true,
                'readonly'    => false,
                'root'        => false,
                'disabled'    => false,
                'sequence'    => $database->sequence + 140,
            ];

            $data[] = [
                'id'          => $resourceId++,
                'parent_id'   => null,
                'database_id' => $database->id,
                'name'        => 'photography',
                'table'       => 'photography',
                'class'       => 'App\Models\Portfolio\Photography',
                'title'       => 'Photography',
                'plural'      => 'Photography',
                'has_owner'   => true,
                'guest'       => true,
                'user'        => true,
                'admin'       => true,
                'global'      => true,
                'menu'        => true,
                'menu_level'  => 1,
                'icon'        => 'fa-camera',
                'public'      => true,
                'readonly'    => false,
                'root'        => false,
                'disabled'    => false,
                'sequence'    => $database->sequence + 150,
            ];

            $data[] = [
                'id'          => $resourceId++,
                'parent_id'   => null,
                'database_id' => $database->id,
                'name'        => 'project',
                'table'       => 'projects',
                'class'       => 'App\Models\Portfolio\Project',
                'title'       => 'Project',
                'plural'      => 'Projects',
                'has_owner'   => true,
                'guest'       => true,
                'user'        => true,
                'admin'       => true,
                'global'      => true,
                'menu'        => true,
                'menu_level'  => 1,
                'icon'        => 'fa-wrench',
                'public'      => true,
                'readonly'    => false,
                'root'        => false,
                'disabled'    => false,
                'sequence'    => $database->sequence + 160,
            ];

            $data[] = [
                'id'          => $resourceId++,
                'parent_id'   => null,
                'database_id' => $database->id,
                'name'        => 'publication',
                'table'       => 'publications',
                'class'       => 'App\Models\Portfolio\Publication',
                'title'       => 'Publication',
                'plural'      => 'Publications',
                'has_owner'   => true,
                'guest'       => true,
                'user'        => true,
                'admin'       => true,
                'global'      => true,
                'menu'        => true,
                'menu_level'  => 1,
                'icon'        => 'fa-book',
                'public'      => true,
                'readonly'    => false,
                'root'        => false,
                'disabled'    => false,
                'sequence'    => $database->sequence + 170,
            ];

            $data[] = [
                'id'          => $resourceId++,
                'parent_id'   => null,
                'database_id' => $database->id,
                'name'        => 'school',
                'table'       => 'schools',
                'class'       => 'App\Models\Portfolio\School',
                'title'       => 'School',
                'plural'      => 'Schools',
                'has_owner'   => false,
                'guest'       => true,
                'user'        => true,
                'admin'       => true,
                'global'      => true,
                'menu'        => false,
                'menu_level'  => 1,
                'icon'        => 'fa-school',
                'public'      => true,
                'readonly'    => false,
                'root'        => false,
                'disabled'    => false,
                'sequence'    => $database->sequence + 180,
            ];

            $data[] = [
                'id'          => $resourceId++,
                'parent_id'   => null,
                'database_id' => $database->id,
                'name'        => 'skill',
                'table'       => 'skills',
                'class'       => 'App\Models\Portfolio\Skill',
                'title'       => 'Skill',
                'plural'      => 'Skills',
                'has_owner'   => true,
                'guest'       => true,
                'user'        => true,
                'admin'       => true,
                'global'      => true,
                'menu'        => true,
                'menu_level'  => 1,
                'icon'        => 'fa-star',
                'public'      => true,
                'readonly'    => false,
                'root'        => false,
                'disabled'    => false,
                'sequence'    => $database->sequence + 190,
            ];

            $data[] = [
                'id'          => $resourceId++,
                'parent_id'   => null,
                'database_id' => $database->id,
                'name'        => 'video',
                'table'       => 'videos',
                'class'       => 'App\Models\Portfolio\Video',
                'title'       => 'Video',
                'plural'      => 'Video',
                'has_owner'   => true,
                'guest'       => true,
                'user'        => true,
                'admin'       => true,
                'global'      => true,
                'menu'        => true,
                'menu_level'  => 1,
                'icon'        => 'fa-video-camera',
                'public'      => true,
                'readonly'    => false,
                'root'        => false,
                'disabled'    => false,
                'sequence'    => $database->sequence + 200,
            ];

            // add timestamps and owner_ids
            for($i=0; $i<count($data);$i++) {
                $data[$i]['created_at'] = now();
                $data[$i]['updated_at'] = now();
                $data[$i]['owner_id']   = $this->rootAdminId;
            }

            for ($i=0; $i<count($data); $i++) {
                $resourceModel->insert($data[$i]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if ($portfolioDatabase = new Database()->where('name', 'portfolio')->first()) {
            new Resource()->where('database_id', $portfolioDatabase->id)->delete();
            $portfolioDatabase->delete();
        }
    }
};
