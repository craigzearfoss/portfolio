<?php

use App\Models\Scopes\AdminPublicScope;
use App\Models\System\Database;
use App\Models\System\Resource;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * The tag used to identify the portfolio database.
     *
     * @var string
     */
    protected $database_tag = 'portfolio_db';

    /**
     * The id of the admin who owns the portfolio database and resources.
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
        $dbName = config('app.' . $this->database_tag);

        if (empty($dbName)) {
            throw new \Exception('app.'.$this->database_tag.' not defined in config\app.php file '
                . ' or PORTFOLIO_DB_DATABASE not defined in .env file.'
            );
        }

        if (empty(DB::select("SHOW DATABASES LIKE '{$dbName}'"))) {
            throw new \Exception("Database `{$dbName}` does not exist.");
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
                'guest'      => 1,
                'user'       => 1,
                'admin'      => 1,
                'global'     => 0,
                'menu'       => 1,
                'menu_level' => 0,
                'icon'       => 'fa-folder',
                'public'     => 1,
                'disabled'   => 0,
                'sequence'   => 1000,
            ],
        ];

        // add timestamps and owner_ids
        for($i=0; $i<count($data);$i++) {
            $data[$i]['created_at'] = now();
            $data[$i]['updated_at'] = now();
            $data[$i]['owner_id']   = $this->rootAdminId;
        }

        Database::insert($data);

        if (!$database = Database::where('database', $dbName)->first()) {

            throw new \Exception($dbName . 'database not found.');

        } else {

            /** -----------------------------------------------------
             * Add portfolio resources.
             ** ----------------------------------------------------- */

            // Note that the parent id refers to the id from the resource table, of the resource_id frm the admin_resources table.
            $resourceId = Resource::withoutGlobalScope(AdminPublicScope::class)->max('id') + 1;

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
                'has_owner'   => 0,
                'guest'       => 0,
                'user'        => 0,
                'admin'       => 1,
                'global'      => 1,
                'menu'        => 1,
                'menu_level'  => 1,
                'icon'        => 'fa-school',
                'public'      => 1,
                'readonly'    => 0,
                'root'        => 1,
                'disabled'    => 0,
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
                'has_owner'   => 1,
                'guest'       => 1,
                'user'        => 1,
                'admin'       => 1,
                'global'      => 0,
                'menu'        => 1,
                'menu_level'  => 1,
                'icon'        => 'fa-image',
                'public'      => 1,
                'readonly'    => 0,
                'root'        => 0,
                'disabled'    => 0,
                'sequence'    => $database->sequence + 20,
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
                'has_owner'   => 1,
                'guest'       => 1,
                'user'        => 1,
                'admin'       => 1,
                'global'      => 0,
                'menu'        => 1,
                'menu_level'  => 1,
                'icon'        => 'fa-trophy',
                'public'      => 1,
                'readonly'    => 0,
                'root'        => 0,
                'disabled'    => 0,
                'sequence'    => $database->sequence + 30,
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
                'has_owner'   => 1,
                'guest'       => 1,
                'user'        => 1,
                'admin'       => 1,
                'global'      => 0,
                'menu'        => 1,
                'menu_level'  => 1,
                'icon'        => 'fa-microphone',
                'public'      => 1,
                'readonly'    => 0,
                'root'        => 0,
                'disabled'    => 0,
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
                'has_owner'   => 1,
                'guest'       => 1,
                'user'        => 1,
                'admin'       => 1,
                'global'      => 0,
                'menu'        => 1,
                'menu_level'  => 1,
                'icon'        => 'fa-thumbs-up',
                'public'      => 1,
                'readonly'    => 0,
                'root'        => 0,
                'disabled'    => 0,
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
                'has_owner'   => 0,
                'guest'       => 0,
                'user'        => 0,
                'admin'       => 1,
                'global'      => 1,
                'menu'        => 0,
                'menu_level'  => 1,
                'icon'        => 'fa-certificate',
                'public'      => 1,
                'readonly'    => 0,
                'root'        => 1,
                'disabled'    => 0,
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
                'has_owner'   => 1,
                'guest'       => 1,
                'user'        => 1,
                'admin'       => 1,
                'global'      => 0,
                'menu'        => 1,
                'menu_level'  => 1,
                'icon'        => 'fa-chalkboard',
                'public'      => 1,
                'readonly'    => 0,
                'root'        => 0,
                'disabled'    => 0,
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
                'has_owner'   => 1,
                'guest'       => 1,
                'user'        => 1,
                'admin'       => 1,
                'global'      => 0,
                'menu'        => 1,
                'menu_level'  => 1,
                'icon'        => 'fa-graduation-cap',
                'public'      => 1,
                'readonly'    => 0,
                'root'        => 0,
                'disabled'    => 0,
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
                'has_owner'   => 1,
                'guest'       => 1,
                'user'        => 1,
                'admin'       => 1,
                'global'      => 0,
                'menu'        => 1,
                'menu_level'  => 1,
                'icon'        => 'fa-briefcase',
                'public'      => 1,
                'readonly'    => 0,
                'root'        => 0,
                'disabled'    => 0,
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
                'has_owner'   => 1,
                'guest'       => 0,
                'user'        => 0,
                'admin'       => 1,
                'global'      => 0,
                'menu'        => 0,
                'menu_level'  => 2,
                'icon'        => 'fa-users',
                'public'      => 0,
                'readonly'    => 0,
                'root'        => 0,
                'disabled'    => 0,
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
                'has_owner'   => 1,
                'guest'       => 0,
                'user'        => 0,
                'admin'       => 1,
                'global'      => 0,
                'menu'        => 0,
                'menu_level'  => 2,
                'icon'        => 'fa-star',
                'public'      => 0,
                'readonly'    => 0,
                'root'        => 0,
                'disabled'    => 0,
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
                'has_owner'   => 1,
                'guest'       => 0,
                'user'        => 0,
                'admin'       => 1,
                'global'      => 0,
                'menu'        => 0,
                'menu_level'  => 2,
                'icon'        => 'fa-cogs',
                'public'      => 0,
                'readonly'    => 0,
                'root'        => 0,
                'disabled'    => 0,
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
                'has_owner'   => 1,
                'guest'       => 1,
                'user'        => 1,
                'admin'       => 1,
                'global'      => 0,
                'menu'        => 1,
                'menu_level'  => 1,
                'icon'        => 'fa-link',
                'sequence'    => $database->sequence + 90,
                'public'      => 1,
                'readonly'    => 0,
                'root'        => 0,
                'disabled'    => 0,
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
                'has_owner'   => 1,
                'guest'       => 1,
                'user'        => 1,
                'admin'       => 1,
                'global'      => 0,
                'menu'        => 1,
                'menu_level'  => 1,
                'icon'        => 'fa-music',
                'public'      => 1,
                'readonly'    => 0,
                'root'        => 0,
                'disabled'    => 0,
                'sequence'    => $database->sequence + 130,
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
                'has_owner'   => 1,
                'guest'       => 1,
                'user'        => 1,
                'admin'       => 1,
                'global'      => 0,
                'menu'        => 1,
                'menu_level'  => 1,
                'icon'        => 'fa-camera',
                'public'      => 1,
                'readonly'    => 0,
                'root'        => 0,
                'disabled'    => 0,
                'sequence'    => $database->sequence + 140,
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
                'has_owner'   => 1,
                'guest'       => 1,
                'user'        => 1,
                'admin'       => 1,
                'global'      => 0,
                'menu'        => 1,
                'menu_level'  => 1,
                'icon'        => 'fa-wrench',
                'public'      => 1,
                'readonly'    => 0,
                'root'        => 0,
                'disabled'    => 0,
                'sequence'    => $database->sequence + 150,
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
                'has_owner'   => 1,
                'guest'       => 1,
                'user'        => 1,
                'admin'       => 1,
                'global'      => 0,
                'menu'        => 1,
                'menu_level'  => 1,
                'icon'        => 'fa-book',
                'public'      => 1,
                'readonly'    => 0,
                'root'        => 0,
                'disabled'    => 0,
                'sequence'    => $database->sequence + 160,
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
                'has_owner'   => 0,
                'guest'       => 0,
                'user'        => 0,
                'admin'       => 1,
                'global'      => 1,
                'menu'        => 0,
                'menu_level'  => 1,
                'icon'        => 'fa-school',
                'public'      => 1,
                'readonly'    => 0,
                'root'        => 1,
                'disabled'    => 0,
                'sequence'    => $database->sequence + 170,
            ];

            $data[] = [
                'id'          => $resourceId++,
                'parent_id'   => null,
                'database_id' => $database->id,
                'name'        => 'skill',
                'table'       => 'skills',
                'title'       => 'Skill',
                'class'       => 'App\Models\Portfolio\Skill',
                'plural'      => 'Skills',
                'has_owner'   => 1,
                'guest'       => 1,
                'user'        => 1,
                'admin'       => 1,
                'global'      => 0,
                'menu'        => 1,
                'menu_level'  => 1,
                'icon'        => 'fa-star',
                'public'      => 1,
                'readonly'    => 0,
                'root'        => 0,
                'disabled'    => 0,
                'sequence'    => $database->sequence + 180,
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
                'has_owner'   => 1,
                'guest'       => 1,
                'user'        => 1,
                'admin'       => 1,
                'global'      => 0,
                'menu'        => 1,
                'menu_level'  => 1,
                'icon'        => 'fa-video-camera',
                'public'      => 1,
                'readonly'    => 0,
                'root'        => 0,
                'disabled'    => 0,
                'sequence'    => $database->sequence + 190,
            ];

            // add timestamps and owner_ids
            for($i=0; $i<count($data);$i++) {
                $data[$i]['created_at'] = now();
                $data[$i]['updated_at'] = now();
                $data[$i]['owner_id']   = $this->rootAdminId;
            }

            for ($i=0; $i<count($data); $i++) {
                Resource::insert($data[$i]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if ($portfolioDatabase = Database::where('name', 'portfolio')->first()) {
            Resource::where('database_id', $portfolioDatabase->id)->delete();
            $portfolioDatabase->delete();
        }
    }
};
