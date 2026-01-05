<?php

use App\Models\System\Database;
use App\Models\System\Resource;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * The tag used to identify the career database.
     *
     * @var string
     */
    protected $database_tag = 'career_db';

    /**
     * The id of the admin who owns the career database and resources.
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
                . ' or CAREER_DB_DATABASE not defined in .env file.'
            );
        }

        if (empty(DB::select("SHOW DATABASES LIKE '{$dbName}'"))) {
            throw new \Exception("Database `{$dbName}` does not exist.");
        }

        //@TODO: Check if the database or and of the resources exist in the databases or resources tables.

        /** -----------------------------------------------------
         * Add career database.
         ** ----------------------------------------------------- */
        $data = [
            [
                //'id'         => 4,
                'name'       => 'career',
                'database'   => config('app.' . $this->database_tag),
                'tag'        => $this->database_tag,
                'title'      => 'Career',
                'plural'     => 'Careers',
                'guest'      => 0,
                'user'       => 0,
                'admin'      => 1,
                'global'     => 0,
                'menu'       => 0,
                'menu_level' => 1,
                'icon'       => 'fa-briefcase',
                'public'     => 0,
                'disabled'   => 0,
                'sequence'   => 3000,
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

            throw new \Exception($dbName . ' database not found.');

        } else {

            /** -----------------------------------------------------
             * Add career resources.
             ** ----------------------------------------------------- */
            $data = [
                [
                    'parent_id'   => null,
                    'database_id' => $database->id,
                    'name'        => 'application',
                    'table'       => 'applications',
                    'class'       => 'App\Models\Career\Application',
                    'title'       => 'Application',
                    'plural'      => 'Applications',
                    'has_owner'   => 1,
                    'guest'       => 0,
                    'user'        => 0,
                    'admin'       => 1,
                    'global'      => 0,
                    'menu'        => 0,
                    'menu_level'  => 2,
                    'icon'        => 'fa-thumbtack',
                    'public'      => 0,
                    'readonly'    => 0,
                    'root'        => 0,
                    'disabled'    => 0,
                    'sequence'    => $database->sequence + 10,
                ],
                [
                    'parent_id'   => null,
                    'database_id' => $database->id,
                    'name'        => 'communication',
                    'table'       => 'communications',
                    'class'       => 'App\Models\Career\Communication',
                    'title'       => 'Communication',
                    'plural'      => 'Communications',
                    'has_owner'   => 1,
                    'guest'       => 0,
                    'user'        => 0,
                    'admin'       => 1,
                    'global'      => 0,
                    'menu'        => 0,
                    'menu_level'  => 3,
                    'icon'        => 'fa-phone',
                    'public'      => 0,
                    'readonly'    => 0,
                    'root'        => 0,
                    'disabled'    => 0,
                    'sequence'    => $database->sequence + 20,
                ],
                [
                    'parent_id'   => null,
                    'database_id' => $database->id,
                    'name'        => 'cover-letter',
                    'table'       => 'cover_letters',
                    'class'       => 'App\Models\Career\CoverLetter',
                    'title'       => 'Cover Letter',
                    'plural'      => 'Cover Letters',
                    'has_owner'   => 1,
                    'guest'       => 0,
                    'user'        => 0,
                    'admin'       => 1,
                    'global'      => 0,
                    'menu'        => 0,
                    'menu_level'  => 3,
                    'icon'        => 'fa-file-text',
                    'public'      => 0,
                    'readonly'    => 0,
                    'root'        => 0,
                    'disabled'    => 0,
                    'sequence'    => $database->sequence + 30,
                ],
                [
                    'parent_id'   => null,
                    'database_id' => $database->id,
                    'name'        => 'event',
                    'table'       => 'events',
                    'class'       => 'App\Models\Career\Event',
                    'title'       => 'Event',
                    'plural'      => 'Events',
                    'has_owner'   => 1,
                    'guest'       => 0,
                    'user'        => 0,
                    'admin'       => 1,
                    'global'      => 0,
                    'menu'        => 0,
                    'menu_level'  => 3,
                    'icon'        => 'fa-calendar',
                    'public'      => 0,
                    'readonly'    => 0,
                    'root'        => 0,
                    'disabled'    => 0,
                    'sequence'    => $database->sequence + 40,
                ],
                [
                    'parent_id'   => null,
                    'database_id' => $database->id,
                    'name'        => 'note',
                    'table'       => 'notes',
                    'class'       => 'App\Models\Career\Note',
                    'title'       => 'Note',
                    'plural'      => 'Notes',
                    'has_owner'   => 1,
                    'guest'       => 0,
                    'user'        => 0,
                    'admin'       => 1,
                    'global'      => 0,
                    'menu'        => 0,
                    'menu_level'  => 3,
                    'icon'        => 'fa-sticky-note',
                    'public'      => 0,
                    'readonly'    => 0,
                    'root'        => 0,
                    'disabled'    => 0,
                    'sequence'    => $database->sequence + 50,
                ],
                [
                    'parent_id'   => null,
                    'database_id' => $database->id,
                    'name'        => 'company',
                    'table'       => 'companies',
                    'class'       => 'App\Models\Career\Company',
                    'title'       => 'Company',
                    'plural'      => 'Companies',
                    'has_owner'   => 1,
                    'guest'       => 0,
                    'user'        => 0,
                    'admin'       => 1,
                    'global'      => 0,
                    'menu'        => 0,
                    'menu_level'  => 2,
                    'icon'        => 'fa-chart-line',
                    'public'      => 0,
                    'readonly'    => 0,
                    'root'        => 0,
                    'disabled'    => 0,
                    'sequence'    => $database->sequence + 60,
                ],
                [
                    'parent_id'   => null,
                    'database_id' => $database->id,
                    'name'        => 'contact',
                    'table'       => 'contacts',
                    'class'       => 'App\Models\Career\Contact',
                    'title'       => 'Contact',
                    'plural'      => 'Contacts',
                    'has_owner'   => 1,
                    'guest'       => 0,
                    'user'        => 0,
                    'admin'       => 1,
                    'global'      => 0,
                    'menu'        => 0,
                    'menu_level'  => 2,
                    'icon'        => 'fa-address-book',
                    'public'      => 0,
                    'readonly'    => 0,
                    'root'        => 0,
                    'disabled'    => 0,
                    'sequence'    => $database->sequence + 70,
                ],
                [
                    'parent_id'   => null,
                    'database_id' => $database->id,
                    'name'        => 'industry',
                    'table'       => 'industries',
                    'class'       => 'App\Models\Career\Industry',
                    'title'       => 'Industry',
                    'plural'      => 'Industries',
                    'has_owner'   => 0,
                    'guest'       => 0,
                    'user'        => 0,
                    'admin'       => 1,
                    'global'      => 1,
                    'menu'        => 0,
                    'menu_level'  => 2,
                    'icon'        => 'fa-industry',
                    'public'      => 0,
                    'readonly'    => 0,
                    'root'        => 1,
                    'disabled'    => 0,
                    'sequence'    => $database->sequence + 80,
                ],
                [
                    'parent_id'   => null,
                    'database_id' => $database->id,
                    'name'        => 'job-board',
                    'table'       => 'job_boards',
                    'class'       => 'App\Models\Career\JobBoard',
                    'title'       => 'Job Board',
                    'plural'      => 'Job Boards',
                    'has_owner'   => 0,
                    'guest'       => 0,
                    'user'        => 0,
                    'admin'       => 1,
                    'global'      => 1,
                    'menu'        => 0,
                    'menu_level'  => 2,
                    'icon'        => 'fa-clipboard',
                    'public'      => 0,
                    'readonly'    => 0,
                    'root'        => 1,
                    'disabled'    => 0,
                    'sequence'    => $database->sequence + 90,
                ],
                [
                    'parent_id'   => null,
                    'database_id' => $database->id,
                    'name'        => 'recruiter',
                    'table'       => 'recruiters',
                    'class'       => 'App\Models\Career\Recruiter',
                    'title'       => 'Recruiter',
                    'plural'      => 'Recruiters',
                    'has_owner'   => 0,
                    'guest'       => 0,
                    'user'        => 0,
                    'admin'       => 1,
                    'global'      => 1,
                    'menu'        => 0,
                    'menu_level'  => 2,
                    'icon'        => 'fa-handshake',
                    'public'      => 0,
                    'readonly'    => 0,
                    'root'        => 0,
                    'disabled'    => 0,
                    'sequence'    => $database->sequence + 100,
                ],
                [
                    'parent_id'   => null,
                    'database_id' => $database->id,
                    'name'        => 'reference',
                    'table'       => 'references',
                    'class'       => 'App\Models\Career\Reference',
                    'title'       => 'Reference',
                    'plural'      => 'References',
                    'has_owner'   => 1,
                    'guest'       => 0,
                    'user'        => 0,
                    'admin'       => 1,
                    'global'      => 0,
                    'menu'        => 0,
                    'menu_level'  => 2,
                    'icon'        => 'fa-address-card',
                    'public'      => 0,
                    'readonly'    => 0,
                    'root'        => 0,
                    'disabled'    => 0,
                    'sequence'    => $database->sequence + 110,
                ],
                [
                    'parent_id'   => null,
                    'database_id' => $database->id,
                    'name'        => 'resume',
                    'table'       => 'resumes',
                    'class'       => 'App\Models\Career\Resume',
                    'title'       => 'Resume',
                    'plural'      => 'Resumes',
                    'has_owner'   => 1,
                    'guest'       => 0,
                    'user'        => 0,
                    'admin'       => 1,
                    'global'      => 0,
                    'menu'        => 0,
                    'menu_level'  => 2,
                    'icon'        => 'fa-file',
                    'public'      => 0,
                    'readonly'    => 0,
                    'root'        => 0,
                    'disabled'    => 0,
                    'sequence'    => $database->sequence + 120,
                ],
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
        if ($careerDatabase = Database::where('name', 'career')->first()) {
            Resource::where('database_id', $careerDatabase->id)->delete();
            $careerDatabase->delete();
        }
    }
};
