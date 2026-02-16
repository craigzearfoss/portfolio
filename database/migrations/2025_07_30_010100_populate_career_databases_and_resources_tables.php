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
    protected string $database_tag = 'career_db';

    /**
     * The id of the admin who owns the career database and resources.
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
            throw new \Exception('app.'.$this->database_tag.' not defined in config\app.php file '
                . ' or CAREER_DB_DATABASE not defined in .env file.'
            );
        }

        if (empty(DB::select("SHOW DATABASES LIKE '$dbName'"))) {
            throw new \Exception("Database `$dbName` does not exist.");
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
                'guest'      => false,
                'user'       => false,
                'admin'      => true,
                'global'     => false,
                'menu'       => true,
                'menu_level' => 0,
                'icon'       => 'fa-briefcase',
                'public'     => false,
                'root'       => false,
                'disabled'   => false,
                'sequence'   => 3000,
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

            throw new \Exception($dbName . ' database not found.');

        } else {

            /** -----------------------------------------------------
             * Add career resources.
             ** ----------------------------------------------------- */

            $resourceModel = new Resource();

            // Note that the parent id refers to the id from the resource table, of the resource_id frm the admin_resources table.
            $resourceId = $resourceModel->withoutGlobalScope(AdminPublicScope::class)->max('id') + 1;

            $applicationResourceId = null;

            $data = [];

            $applicationResourceId = $resourceId;
            $data[] = [
                'id'          => $resourceId++,
                'parent_id'   => null,
                'database_id' => $database->id,
                'name'        => 'application',
                'table'       => 'applications',
                'class'       => 'App\Models\Career\Application',
                'title'       => 'Application',
                'plural'      => 'Applications',
                'has_owner'   => true,
                'guest'       => false,
                'user'        => false,
                'admin'       => true,
                'global'      => false,
                'menu'        => true,
                'menu_level'  => 1,
                'icon'        => 'fa-thumbtack',
                'public'      => false,
                'readonly'    => false,
                'root'        => false,
                'disabled'    => false,
                'sequence'    => $database->sequence + 10,
            ];

            $data[] = [
                'id'          => $resourceId++,
                'parent_id'   => $applicationResourceId,
                'database_id' => $database->id,
                'name'        => 'communication',
                'table'       => 'communications',
                'class'       => 'App\Models\Career\Communication',
                'title'       => 'Communication',
                'plural'      => 'Communications',
                'has_owner'   => true,
                'guest'       => false,
                'user'        => false,
                'admin'       => true,
                'global'      => false,
                'menu'        => true,
                'menu_level'  => 2,
                'icon'        => 'fa-phone',
                'public'      => false,
                'readonly'    => false,
                'root'        => false,
                'disabled'    => false,
                'sequence'    => $database->sequence + 20,
            ];

            $data[] = [
                'id'          => $resourceId++,
                'parent_id'   => $applicationResourceId,
                'database_id' => $database->id,
                'name'        => 'cover-letter',
                'table'       => 'cover_letters',
                'class'       => 'App\Models\Career\CoverLetter',
                'title'       => 'Cover Letter',
                'plural'      => 'Cover Letters',
                'has_owner'   => true,
                'guest'       => false,
                'user'        => false,
                'admin'       => true,
                'global'      => false,
                'menu'        => true,
                'menu_level'  => 2,
                'icon'        => 'fa-file-text',
                'public'      => false,
                'readonly'    => false,
                'root'        => false,
                'disabled'    => false,
                'sequence'    => $database->sequence + 30,
            ];

            $data[] = [
                'id'          => $resourceId++,
                'parent_id'   => $applicationResourceId,
                'database_id' => $database->id,
                'name'        => 'event',
                'table'       => 'events',
                'class'       => 'App\Models\Career\Event',
                'title'       => 'Event',
                'plural'      => 'Events',
                'has_owner'   => true,
                'guest'       => false,
                'user'        => false,
                'admin'       => true,
                'global'      => false,
                'menu'        => true,
                'menu_level'  => 2,
                'icon'        => 'fa-calendar',
                'public'      => false,
                'readonly'    => false,
                'root'        => false,
                'disabled'    => false,
                'sequence'    => $database->sequence + 40,
            ];

            $data[] = [
                'id'          => $resourceId++,
                'parent_id'   => $applicationResourceId,
                'database_id' => $database->id,
                'name'        => 'note',
                'table'       => 'notes',
                'class'       => 'App\Models\Career\Note',
                'title'       => 'Note',
                'plural'      => 'Notes',
                'has_owner'   => true,
                'guest'       => false,
                'user'        => false,
                'admin'       => true,
                'global'      => false,
                'menu'        => true,
                'menu_level'  => 2,
                'icon'        => 'fa-sticky-note',
                'public'      => false,
                'readonly'    => false,
                'root'        => false,
                'disabled'    => false,
                'sequence'    => $database->sequence + 50,
            ];

            $data[] = [
                'id'          => $resourceId++,
                'parent_id'   => null,
                'database_id' => $database->id,
                'name'        => 'company',
                'table'       => 'companies',
                'class'       => 'App\Models\Career\Company',
                'title'       => 'Company',
                'plural'      => 'Companies',
                'has_owner'   => true,
                'guest'       => false,
                'user'        => false,
                'admin'       => true,
                'global'      => false,
                'menu'        => true,
                'menu_level'  => 1,
                'icon'        => 'fa-chart-line',
                'public'      => false,
                'readonly'    => false,
                'root'        => false,
                'disabled'    => false,
                'sequence'    => $database->sequence + 60,
            ];

            $data[] = [
                'id'          => $resourceId++,
                'parent_id'   => null,
                'database_id' => $database->id,
                'name'        => 'contact',
                'table'       => 'contacts',
                'class'       => 'App\Models\Career\Contact',
                'title'       => 'Contact',
                'plural'      => 'Contacts',
                'has_owner'   => true,
                'guest'       => false,
                'user'        => false,
                'admin'       => true,
                'global'      => false,
                'menu'        => true,
                'menu_level'  => 1,
                'icon'        => 'fa-address-book',
                'public'      => false,
                'readonly'    => false,
                'root'        => false,
                'disabled'    => false,
                'sequence'    => $database->sequence + 70,
            ];

            $data[] = [
                'id'          => $resourceId++,
                'parent_id'   => null,
                'database_id' => $database->id,
                'name'        => 'industry',
                'table'       => 'industries',
                'class'       => 'App\Models\Career\Industry',
                'title'       => 'Industry',
                'plural'      => 'Industries',
                'has_owner'   => false,
                'guest'       => true,
                'user'        => true,
                'admin'       => true,
                'global'      => true,
                'menu'        => false,
                'menu_level'  => 1,
                'icon'        => 'fa-industry',
                'public'      => true,
                'readonly'    => false,
                'root'        => false,
                'disabled'    => false,
                'sequence'    => $database->sequence + 80,
            ];

            $data[] = [
                'id'          => $resourceId++,
                'parent_id'   => null,
                'database_id' => $database->id,
                'name'        => 'job-board',
                'table'       => 'job_boards',
                'class'       => 'App\Models\Career\JobBoard',
                'title'       => 'Job Board',
                'plural'      => 'Job Boards',
                'has_owner'   => false,
                'guest'       => true,
                'user'        => true,
                'admin'       => true,
                'global'      => true,
                'menu'        => false,
                'menu_level'  => 1,
                'icon'        => 'fa-clipboard',
                'public'      => true,
                'readonly'    => false,
                'root'        => false,
                'disabled'    => false,
                'sequence'    => $database->sequence + 90,
            ];

            $data[] = [
                'id'          => $resourceId++,
                'parent_id'   => null,
                'database_id' => $database->id,
                'name'        => 'job-search-log',
                'table'       => 'job_search-log',
                'class'       => 'App\Models\Career\JobSearchLog',
                'title'       => 'Job Search Log',
                'plural'      => 'Job Search Log',
                'has_owner'   => false,
                'guest'       => false,
                'user'        => false,
                'admin'       => true,
                'global'      => false,
                'menu'        => true,
                'menu_level'  => 1,
                'icon'        => 'fa-clipboard',
                'public'      => false,
                'readonly'    => false,
                'root'        => false,
                'disabled'    => false,
                'sequence'    => $database->sequence + 100,
            ];

            $data[] = [
                'id'          => $resourceId++,
                'parent_id'   => null,
                'database_id' => $database->id,
                'name'        => 'recruiter',
                'table'       => 'recruiters',
                'class'       => 'App\Models\Career\Recruiter',
                'title'       => 'Recruiter',
                'plural'      => 'Recruiters',
                'has_owner'   => false,
                'guest'       => true,
                'user'        => true,
                'admin'       => true,
                'global'      => true,
                'menu'        => false,
                'menu_level'  => 1,
                'icon'        => 'fa-handshake',
                'public'      => true,
                'readonly'    => false,
                'root'        => false,
                'disabled'    => false,
                'sequence'    => $database->sequence + 110,
            ];

            $data[] = [
                'id'          => $resourceId++,
                'parent_id'   => null,
                'database_id' => $database->id,
                'name'        => 'reference',
                'table'       => 'references',
                'class'       => 'App\Models\Career\Reference',
                'title'       => 'Reference',
                'plural'      => 'References',
                'has_owner'   => true,
                'guest'       => false,
                'user'        => false,
                'admin'       => true,
                'global'      => false,
                'menu'        => true,
                'menu_level'  => 1,
                'icon'        => 'fa-address-card',
                'public'      => false,
                'readonly'    => false,
                'root'        => false,
                'disabled'    => false,
                'sequence'    => $database->sequence + 120,
            ];

            $data[] = [
                'id'          => $resourceId++,
                'parent_id'   => null,
                'database_id' => $database->id,
                'name'        => 'resume',
                'table'       => 'resumes',
                'class'       => 'App\Models\Career\Resume',
                'title'       => 'Resume',
                'plural'      => 'Resumes',
                'has_owner'   => true,
                'guest'       => false,
                'user'        => false,
                'admin'       => true,
                'global'      => false,
                'menu'        => true,
                'menu_level'  => 1,
                'icon'        => 'fa-file',
                'public'      => false,
                'readonly'    => false,
                'root'        => false,
                'disabled'    => false,
                'sequence'    => $database->sequence + 130,
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
        if ($careerDatabase = new Database()->where('name', 'career')->first()) {
            new Resource()->where('database_id', $careerDatabase->id)->delete();
            $careerDatabase->delete();
        }
    }
};
