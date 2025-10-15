<?php

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
                //'id'       => 3,
                'name'     => 'portfolio',
                'database' => config('app.' . $this->database_tag),
                'tag'      => $this->database_tag,
                'title'    => 'Portfolio',
                'plural'   => 'Portfolios',
                'icon'     => 'fa-folder',
                'guest'    => 1,
                'user'     => 1,
                'admin'    => 1,
                'sequence' => 1000,
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

        if (!$database = Database::where('database', $dbName)->first()) {

            throw new \Exception($dbName . 'database not found.');

        } else {

            /** -----------------------------------------------------
             * Add portfolio resources.
             ** ----------------------------------------------------- */
            $data = [
                [
                    'parent_id'   => null,
                    'database_id' => $database->id,
                    'name'        => 'academy',
                    'table'       => 'academies',
                    'title'       => 'Academy',
                    'plural'      => 'Academies',
                    'guest'       => 0,
                    'user'        => 0,
                    'admin'       => 1,
                    'icon'        => 'fa-school',
                    'level'       => 2,
                    'sequence'    => $database->sequence + 10,
                    'public'      => 1,
                    'readonly'    => 0,
                    'root'        => 1,
                    'disabled'    => 0,
                ],
                [
                    'parent_id'   => null,
                    'database_id' => $database->id,
                    'name'        => 'art',
                    'table'       => 'art',
                    'title'       => 'Art',
                    'plural'      => 'Art',
                    'guest'       => 1,
                    'user'        => 1,
                    'admin'       => 1,
                    'icon'        => 'fa-image',
                    'level'       => 2,
                    'sequence'    => $database->sequence + 20,
                    'public'      => 1,
                    'readonly'    => 0,
                    'root'        => 0,
                    'disabled'    => 0,
                ],
                [
                    'parent_id'   => null,
                    'database_id' => $database->id,
                    'name'        => 'audio',
                    'table'       => 'audios',
                    'title'       => 'Audio',
                    'plural'      => 'Audio',
                    'guest'       => 1,
                    'user'        => 1,
                    'admin'       => 1,
                    'icon'        => 'fa-microphone',
                    'level'       => 2,
                    'sequence'    => $database->sequence + 30,
                    'public'      => 1,
                    'readonly'    => 0,
                    'root'        => 0,
                    'disabled'    => 0,
                ],
                [
                    'parent_id'   => null,
                    'database_id' => $database->id,
                    'name'        => 'certification',
                    'table'       => 'certifications',
                    'title'       => 'Certification',
                    'plural'      => 'Certifications',
                    'guest'       => 1,
                    'user'        => 1,
                    'admin'       => 1,
                    'icon'        => 'fa-graduation-cap',
                    'level'       => 2,
                    'sequence'    => $database->sequence + 40,
                    'public'      => 1,
                    'readonly'    => 0,
                    'root'        => 0,
                    'disabled'    => 0,
                ],                [
                    'parent_id'   => null,
                    'database_id' => $database->id,
                    'name'        => 'course',
                    'table'       => 'courses',
                    'title'       => 'Course',
                    'plural'      => 'Courses',
                    'guest'       => 1,
                    'user'        => 1,
                    'admin'       => 1,
                    'icon'        => 'fa-chalkboard',
                    'level'       => 2,
                    'sequence'    => $database->sequence + 50,
                    'public'      => 1,
                    'readonly'    => 0,
                    'root'        => 0,
                    'disabled'    => 0,
               ],
                [
                    'parent_id'   => null,
                    'database_id' => $database->id,
                    'name'        => 'job',
                    'table'       => 'jobs',
                    'title'       => 'Job',
                    'plural'      => 'Jobs',
                    'guest'       => 1,
                    'user'        => 1,
                    'admin'       => 1,
                    'icon'        => 'fa-briefcase',
                    'level'       => 2,
                    'sequence'    => $database->sequence + 60,
                    'public'      => 1,
                    'readonly'    => 0,
                    'root'        => 0,
                    'disabled'    => 0,
                ],
                [
                    'parent_id'   => null,
                    'database_id' => $database->id,
                    'name'        => 'job-coworker',
                    'table'       => 'job_coworkers',
                    'title'       => 'Job Coworker',
                    'plural'      => 'Job Coworkers',
                    'guest'       => 0,
                    'user'        => 0,
                    'admin'       => 1,
                    'icon'        => 'fa-users',
                    'level'       => 3,
                    'sequence'    => $database->sequence + 70,
                    'public'      => 0,
                    'readonly'    => 0,
                    'root'        => 0,
                    'disabled'    => 0,
                ],
                [
                    'parent_id'   => null,
                    'database_id' => $database->id,
                    'name'        => 'job-task',
                    'table'       => 'job_tasks',
                    'title'       => 'Job Task',
                    'plural'      => 'Job Tasks',
                    'guest'       => 0,
                    'user'        => 0,
                    'admin'       => 1,
                    'icon'        => 'fa-cogs',
                    'level'       => 3,
                    'sequence'    => $database->sequence + 80,
                    'public'      => 0,
                    'readonly'    => 0,
                    'root'        => 0,
                    'disabled'    => 0,
                ],
                [
                    'parent_id'   => null,
                    'database_id' => $database->id,
                    'name'        => 'link',
                    'table'       => 'links',
                    'title'       => 'Link',
                    'plural'      => 'Links',
                    'guest'       => 1,
                    'user'        => 1,
                    'admin'       => 1,
                    'icon'        => 'fa-link',
                    'level'       => 2,
                    'sequence'    => $database->sequence + 90,
                    'public'      => 1,
                    'readonly'    => 0,
                    'root'        => 0,
                    'disabled'    => 0,
                ],
                [
                    'parent_id'   => null,
                    'database_id' => $database->id,
                    'name'        => 'music',
                    'table'       => 'music',
                    'title'       => 'Music',
                    'plural'      => 'Music',
                    'guest'       => 1,
                    'user'        => 1,
                    'admin'       => 1,
                    'icon'        => 'fa-music',
                    'level'       => 2,
                    'sequence'    => $database->sequence + 100,
                    'public'      => 1,
                    'readonly'    => 0,
                    'root'        => 0,
                    'disabled'    => 0,
                ],
                [
                    'parent_id'   => null,
                    'database_id' => $database->id,
                    'name'        => 'project',
                    'table'       => 'projects',
                    'title'       => 'Project',
                    'plural'      => 'Projects',
                    'guest'       => 1,
                    'user'        => 1,
                    'admin'       => 1,
                    'icon'        => 'fa-wrench',
                    'level'       => 2,
                    'sequence'    => $database->sequence + 110,
                    'public'      => 1,
                    'readonly'    => 0,
                    'root'        => 0,
                    'disabled'    => 0,
                ],
                [
                    'parent_id'   => null,
                    'database_id' => $database->id,
                    'name'        => 'publication',
                    'table'       => 'publications',
                    'title'       => 'Publication',
                    'plural'      => 'Publications',
                    'guest'       => 1,
                    'user'        => 1,
                    'admin'       => 1,
                    'icon'        => 'fa-book',
                    'level'       => 2,
                    'sequence'    => $database->sequence + 120,
                    'public'      => 1,
                    'readonly'    => 0,
                    'root'        => 0,
                    'disabled'    => 0,
                ],
                [
                    'parent_id'   => null,
                    'database_id' => $database->id,
                    'name'        => 'skill',
                    'table'       => 'skills',
                    'title'       => 'Skill',
                    'plural'      => 'Skills',
                    'guest'       => 1,
                    'user'        => 1,
                    'admin'       => 1,
                    'icon'        => 'fa-certificate',
                    'level'       => 2,
                    'sequence'    => $database->sequence + 130,
                    'public'      => 1,
                    'readonly'    => 0,
                    'root'        => 0,
                    'disabled'    => 0,
                ],
                [
                    'parent_id'   => null,
                    'database_id' => $database->id,
                    'name'        => 'unit',
                    'table'       => 'units',
                    'title'       => 'Unit',
                    'plural'      => 'Units',
                    'guest'       => 0,
                    'user'        => 0,
                    'admin'       => 0,
                    'icon'        => 'fa-video-camera',
                    'level'       => 2,
                    'sequence'    => $database->sequence + 40,
                    'public'      => 0,
                    'readonly'    => 0,
                    'root'        => 1,
                    'disabled'    => 0,
                ],
                [
                    'parent_id'   => null,
                    'database_id' => $database->id,
                    'name'        => 'video',
                    'table'       => 'videos',
                    'title'       => 'Video',
                    'plural'      => 'Video',
                    'guest'       => 1,
                    'user'        => 1,
                    'admin'       => 1,
                    'icon'        => 'fa-video-camera',
                    'level'       => 2,
                    'sequence'    => $database->sequence + 50,
                    'public'      => 1,
                    'readonly'    => 0,
                    'root'        => 0,
                    'disabled'    => 0,
                ],
            ];

            // add timestamps and owner_ids
            for($i=0; $i<count($data);$i++) {
                $data[$i]['created_at'] = now();
                $data[$i]['updated_at'] = now();
                $data[$i]['owner_id']   = $this->rootAdminId;
            }

            Resource::insert($data);
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
