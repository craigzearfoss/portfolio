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
                //'id'       => 4,
                'name'     => 'career',
                'database' => config('app.' . $this->database_tag),
                'tag'      => $this->database_tag,
                'title'    => 'Career',
                'plural'   => 'Careers',
                'guest'    => 0,
                'user'     => 0,
                'admin'    => 1,
                'global'   => 0,
                'icon'     => 'fa-briefcase',
                'sequence' => 3000,
                'public'   => 0,
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
                    'title'       => 'Application',
                    'plural'      => 'Applications',
                    'guest'       => 0,
                    'user'        => 0,
                    'admin'       => 1,
                    'global'      => 0,
                    'icon'        => 'fa-thumbtack',
                    'level'       => 2,
                    'sequence'    => $database->sequence + 10,
                    'public'      => 0,
                    'readonly'    => 0,
                    'root'        => 0,
                    'disabled'    => 0,
                ],
                [
                    'parent_id'   => null,
                    'database_id' => $database->id,
                    'name'        => 'communication',
                    'table'       => 'communications',
                    'title'       => 'Communication',
                    'plural'      => 'Communications',
                    'guest'       => 0,
                    'user'        => 0,
                    'admin'       => 1,
                    'global'      => 0,
                    'icon'        => 'fa-phone',
                    'level'       => 2,
                    'sequence'    => $database->sequence + 20,
                    'public'      => 0,
                    'readonly'    => 0,
                    'root'        => 0,
                    'disabled'    => 0,
                ],
                [
                    'parent_id'   => null,
                    'database_id' => $database->id,
                    'name'        => 'company',
                    'table'       => 'companies',
                    'title'       => 'Company',
                    'plural'      => 'Companies',
                    'guest'       => 0,
                    'user'        => 0,
                    'admin'       => 1,
                    'global'      => 0,
                    'icon'        => 'fa-chart-line',
                    'level'       => 2,
                    'sequence'    => $database->sequence + 30,
                    'public'      => 0,
                    'readonly'    => 0,
                    'root'        => 0,
                    'disabled'    => 0,
                ],
                [
                    'parent_id'   => null,
                    'database_id' => $database->id,
                    'name'        => 'contact',
                    'table'       => 'contacts',
                    'title'       => 'Contact',
                    'plural'      => 'Contacts',
                    'guest'       => 0,
                    'user'        => 0,
                    'admin'       => 1,
                    'global'      => 0,
                    'icon'        => 'fa-address-book',
                    'level'       => 2,
                    'sequence'    => $database->sequence + 40,
                    'public'      => 0,
                    'readonly'    => 0,
                    'root'        => 0,
                    'disabled'    => 0,
                ],
                [
                    'parent_id'   => null,
                    'database_id' => $database->id,
                    'name'        => 'cover-letter',
                    'table'       => 'cover_letters',
                    'title'       => 'Cover Letter',
                    'plural'      => 'Cover Letters',
                    'guest'       => 0,
                    'user'        => 0,
                    'admin'       => 1,
                    'global'      => 0,
                    'icon'        => 'fa-file-text',
                    'level'       => 2,
                    'sequence'    => $database->sequence + 50,
                    'public'      => 0,
                    'readonly'    => 0,
                    'root'        => 0,
                    'disabled'    => 0,
                ],
                [
                    'parent_id'   => null,
                    'database_id' => $database->id,
                    'name'        => 'event',
                    'table'       => 'events',
                    'title'       => 'Event',
                    'plural'      => 'Events',
                    'guest'       => 0,
                    'user'        => 0,
                    'admin'       => 1,
                    'global'      => 0,
                    'icon'        => 'fa-calendar',
                    'level'       => 2,
                    'sequence'    => $database->sequence + 60,
                    'public'      => 0,
                    'readonly'    => 0,
                    'root'        => 0,
                    'disabled'    => 0,
                ],
                [
                    'parent_id'   => null,
                    'database_id' => $database->id,
                    'name'        => 'industry',
                    'table'       => 'industries',
                    'title'       => 'Industry',
                    'plural'      => 'Industries',
                    'guest'       => 0,
                    'user'        => 0,
                    'admin'       => 1,
                    'global'      => 1,
                    'icon'        => 'fa-industry',
                    'level'       => 2,
                    'sequence'    => $database->sequence + 70,
                    'public'      => 0,
                    'readonly'    => 0,
                    'root'        => 1,
                    'disabled'    => 0,
                ],
                [
                    'parent_id'   => null,
                    'database_id' => $database->id,
                    'name'        => 'job-board',
                    'table'       => 'job_boards',
                    'title'       => 'Job Board',
                    'plural'      => 'Job Boards',
                    'guest'       => 0,
                    'user'        => 0,
                    'admin'       => 1,
                    'global'      => 1,
                    'icon'        => 'fa-clipboard',
                    'level'       => 2,
                    'sequence'    => $database->sequence + 80,
                    'public'      => 0,
                    'readonly'    => 0,
                    'root'        => 1,
                    'disabled'    => 0,
                ],
                [
                    'parent_id'   => null,
                    'database_id' => $database->id,
                    'name'        => 'note',
                    'table'       => 'notes',
                    'title'       => 'Note',
                    'plural'      => 'Notes',
                    'guest'       => 0,
                    'user'        => 0,
                    'admin'       => 1,
                    'global'      => 0,
                    'icon'        => 'fa-sticky-note',
                    'level'       => 2,
                    'sequence'    => $database->sequence + 90,
                    'public'      => 0,
                    'readonly'    => 0,
                    'root'        => 0,
                    'disabled'    => 0,
                ],
                [
                    'parent_id'   => null,
                    'database_id' => $database->id,
                    'name'        => 'recruiter',
                    'table'       => 'recruiters',
                    'title'       => 'Recruiter',
                    'plural'      => 'Recruiters',
                    'guest'       => 0,
                    'user'        => 0,
                    'admin'       => 1,
                    'global'      => 1,
                    'icon'        => 'fa-handshake',
                    'level'       => 2,
                    'sequence'    => $database->sequence + 100,
                    'public'      => 0,
                    'readonly'    => 0,
                    'root'        => 0,
                    'disabled'    => 0,
                ],
                [
                    'parent_id'   => null,
                    'database_id' => $database->id,
                    'name'        => 'reference',
                    'table'       => 'references',
                    'title'       => 'Reference',
                    'plural'      => 'References',
                    'guest'       => 0,
                    'user'        => 0,
                    'admin'       => 1,
                    'global'      => 0,
                    'icon'        => 'fa-address-card',
                    'level'       => 2,
                    'sequence'    => $database->sequence + 110,
                    'public'      => 0,
                    'readonly'    => 0,
                    'root'        => 0,
                    'disabled'    => 0,
                ],
                [
                    'parent_id'   => null,
                    'database_id' => $database->id,
                    'name'        => 'resume',
                    'table'       => 'resumes',
                    'title'       => 'Resume',
                    'plural'      => 'Resumes',
                    'guest'       => 0,
                    'user'        => 0,
                    'admin'       => 1,
                    'global'      => 0,
                    'icon'        => 'fa-file',
                    'level'       => 2,
                    'sequence'    => $database->sequence + 120,
                    'public'      => 0,
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
        if ($careerDatabase = Database::where('name', 'career')->first()) {
            Resource::where('database_id', $careerDatabase->id)->delete();
            $careerDatabase->delete();
        }
    }
};
