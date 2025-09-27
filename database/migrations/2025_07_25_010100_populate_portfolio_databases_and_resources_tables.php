<?php

use \App\Models\Database;
use \App\Models\Resource;
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
     * The id of the admin who owns the portfolio database resources.
     * The admin must have root permissions.
     *
     * @var int
     */
    protected $ownerId = 1;

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
                'sequence' => 3000,
                'public'   => 1,
                'disabled' => 0,
            ],
        ];

        // add timestamps and owner_ids
        for($i=0; $i<count($data);$i++) {
            $data[$i]['created_at'] = now();
            $data[$i]['updated_at'] = now();
            $data[$i]['owner_id']   = $this->ownerId;
        }

        Database::insert($data);

        if (!$row = Database::where('database', '=', 'portfolio')->first()) {

            throw new \Exception('portfolio database not found.');

        } else {

            $databaseId = $row->id;

            $data = [
                [
                    'database_id' => $databaseId,
                    'name'        => 'academy',
                    'table'       => 'academies',
                    'title'       => 'Academy',
                    'plural'      => 'Academies',
                    'guest'       => 0,
                    'user'        => 0,
                    'admin'       => 1,
                    'icon'        => 'fa-school',
                    'sequence'    => 3010,
                    'public'      => 0,
                    'readonly'    => 0,
                    'root'        => 1,
                    'disabled'    => 0,
                ],
                [
                    'database_id' => $databaseId,
                    'name'        => 'art',
                    'table'       => 'art',
                    'title'       => 'Art',
                    'plural'      => 'Art',
                    'guest'       => 1,
                    'user'        => 0,
                    'admin'       => 1,
                    'icon'        => 'fa-image',
                    'sequence'    => 3020,
                    'public'      => 1,
                    'readonly'    => 0,
                    'root'        => 1,
                    'disabled'    => 0,
                ],
                [
                    'database_id' => $databaseId,
                    'name'        => 'certification',
                    'table'       => 'certifications',
                    'title'       => 'Certification',
                    'plural'      => 'Certifications',
                    'guest'       => 1,
                    'user'        => 0,
                    'admin'       => 1,
                    'icon'        => 'fa-graduation-cap',
                    'sequence'    => 3030,
                    'public'      => 1,
                    'readonly'    => 0,
                    'root'        => 1,
                    'disabled'    => 0,
                ],                [
                    'database_id' => $databaseId,
                    'name'        => 'course',
                    'table'       => 'courses',
                    'title'       => 'Course',
                    'plural'      => 'Courses',
                    'guest'       => 1,
                    'user'        => 0,
                    'admin'       => 1,
                    'icon'        => 'fa-chalkboard',
                    'sequence'    => 3040,
                    'public'      => 1,
                    'readonly'    => 0,
                    'root'        => 1,
                    'disabled'    => 0,
               ],
                [
                    'database_id' => $databaseId,
                    'name'        => 'job',
                    'table'       => 'jobs',
                    'title'       => 'Job',
                    'plural'      => 'Jobs',
                    'guest'       => 0,
                    'user'        => 0,
                    'admin'       => 1,
                    'icon'        => 'fa-briefcase',
                    'sequence'    => 3050,
                    'public'      => 0,
                    'readonly'    => 0,
                    'root'        => 1,
                    'disabled'    => 0,
                ],
                [
                    'database_id' => $databaseId,
                    'name'        => 'job-coworker',
                    'table'       => 'job_coworkers',
                    'title'       => 'Job Coworker',
                    'plural'      => 'Job Coworkers',
                    'guest'       => 0,
                    'user'        => 0,
                    'admin'       => 1,
                    'icon'        => 'fa-users',
                    'sequence'    => 3060,
                    'public'      => 0,
                    'readonly'    => 0,
                    'root'        => 1,
                    'disabled'    => 0,
                ],
                [
                    'database_id' => $databaseId,
                    'name'        => 'job-task',
                    'table'       => 'job_tasks',
                    'title'       => 'Job Task',
                    'plural'      => 'Job Tasks',
                    'guest'       => 0,
                    'user'        => 0,
                    'admin'       => 1,
                    'icon'        => 'fa-cogs',
                    'sequence'    => 3070,
                    'public'      => 0,
                    'readonly'    => 0,
                    'root'        => 1,
                    'disabled'    => 0,
                ],
                [
                    'database_id' => $databaseId,
                    'name'        => 'link',
                    'table'       => 'links',
                    'title'       => 'Link',
                    'plural'      => 'Links',
                    'guest'       => 1,
                    'user'        => 0,
                    'admin'       => 1,
                    'icon'        => 'fa-link',
                    'sequence'    => 3080,
                    'public'      => 1,
                    'readonly'    => 0,
                    'root'        => 1,
                    'disabled'    => 0,
                ],
                [
                    'database_id' => $databaseId,
                    'name'        => 'music',
                    'table'       => 'music',
                    'title'       => 'Music',
                    'plural'      => 'Music',
                    'guest'       => 1,
                    'user'        => 0,
                    'admin'       => 1,
                    'icon'        => 'fa-music',
                    'sequence'    => 3090,
                    'public'      => 1,
                    'readonly'    => 0,
                    'root'        => 1,
                    'disabled'    => 0,
                ],
                [
                    'database_id' => $databaseId,
                    'name'        => 'project',
                    'table'       => 'projects',
                    'title'       => 'Project',
                    'plural'      => 'Projects',
                    'guest'       => 1,
                    'user'        => 0,
                    'admin'       => 1,
                    'icon'        => 'fa-wrench',
                    'sequence'    => 3100,
                    'public'      => 1,
                    'readonly'    => 0,
                    'root'        => 1,
                    'disabled'    => 0,
                ],
/*
                [
                    'database_id' => $databaseId,
                    'name'        => 'publication',
                    'table'       => 'publications',
                    'title'       => 'Publication',
                    'plural'      => 'Publications',
                    'guest'       => 1,
                    'user'        => 0,
                    'admin'       => 1,
                    'icon'        => 'fa-pencil',
                    'sequence'    => 3110,
                    'public'      => 1,
                    'readonly'    => 0,
                    'root'        => 1,
                    'disabled'    => 0,
                ],
*/
                [
                    'database_id' => $databaseId,
                    'name'        => 'skill',
                    'table'       => 'skills',
                    'title'       => 'Skill',
                    'plural'      => 'Skills',
                    'guest'       => 0,
                    'user'        => 0,
                    'admin'       => 1,
                    'icon'        => 'fa-certificate',
                    'sequence'    => 3120,
                    'public'      => 0,
                    'readonly'    => 0,
                    'root'        => 1,
                    'disabled'    => 0,
                ],
                [
                    'database_id' => $databaseId,
                    'name'        => 'unit',
                    'table'       => 'units',
                    'title'       => 'Unit',
                    'plural'      => 'Units',
                    'guest'       => 0,
                    'user'        => 0,
                    'admin'       => 1,
                    'icon'        => 'fa-video-camera',
                    'sequence'    => 3130,
                    'public'      => 0,
                    'readonly'    => 0,
                    'root'        => 1,
                    'disabled'    => 0,
                ],
                [
                    'database_id' => $databaseId,
                    'name'        => 'video',
                    'table'       => 'videos',
                    'title'       => 'Video',
                    'plural'      => 'Videos',
                    'guest'       => 1,
                    'user'        => 0,
                    'admin'       => 1,
                    'icon'        => 'fa-video-camera',
                    'sequence'    => 3140,
                    'public'      => 1,
                    'readonly'    => 0,
                    'root'        => 1,
                    'disabled'    => 0,
                ],
            ];

            // add timestamps and owner_ids
            for($i=0; $i<count($data);$i++) {
                $data[$i]['created_at'] = now();
                $data[$i]['updated_at'] = now();
                $data[$i]['owner_id']   = $this->ownerId;
            }

            Resource::insert($data);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //@TODO: Delete portfolio entries from core_db.databases and core_db.resources tables.
    }
};
