<?php

use \App\Models\Database;
use \App\Models\Resource;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $data = [
            [
                //'id'       => 4,
                'name'     => 'career',     //config('app.db_career'),    //TODO: using config method brings back null?
                'database' => 'career',     //config('app.db_career'),    //TODO: using config method brings back null?
                'tag'      => 'career_db',
                'title'    => 'Career',
                'plural'   => 'Careers',
                'guest'    => 0,
                'user'     => 0,
                'admin'    => 1,
                'icon'     => 'fa-briefcase',
                'sequence' => 4000,
                'public'   => 1,
                'disabled' => 0,
                'admin_id' => 1,
            ],
        ];

        Database::insert($data);

        if (!$row = Database::where('database', '=', 'career')->first()) {

            throw new \Exception('career database not found.');

        } else {

            $databaseId = $row->id;

            $data = [
                [
                    'database_id' => $databaseId,
                    'name'        => 'application',
                    'table'       => 'applications',
                    'title'       => 'Application',
                    'plural'      => 'Applications',
                    'guest'       => 0,
                    'user'        => 0,
                    'admin'       => 1,
                    'icon'        => 'fa-thumbtack',
                    'sequence'    => 4010,
                    'public'      => 0,
                    'readonly'    => 0,
                    'root'        => 1,
                    'disabled'    => 0,
                    'admin_id'    => 1,
                ],
                [
                    'database_id' => $databaseId,
                    'name'        => 'communication',
                    'table'       => 'communications',
                    'title'       => 'Communication',
                    'plural'      => 'Communications',
                    'guest'       => 0,
                    'user'        => 0,
                    'admin'       => 1,
                    'icon'        => 'fa-phone',
                    'sequence'    => 4020,
                    'public'      => 0,
                    'readonly'    => 0,
                    'root'        => 1,
                    'disabled'    => 0,
                    'admin_id'    => 1,
                ],
                [
                    'database_id' => $databaseId,
                    'name'        => 'company',
                    'table'       => 'companies',
                    'title'       => 'Company',
                    'plural'      => 'Companies',
                    'guest'       => 0,
                    'user'        => 0,
                    'admin'       => 1,
                    'icon'        => 'fa-chart-line',
                    'sequence'    => 4030,
                    'public'      => 0,
                    'readonly'    => 0,
                    'root'        => 1,
                    'disabled'    => 0,
                    'admin_id'    => 1,
                ],
                [
                    'database_id' => $databaseId,
                    'name'        => 'contact',
                    'table'       => 'contacts',
                    'title'       => 'Contact',
                    'plural'      => 'Contacts',
                    'guest'       => 0,
                    'user'        => 0,
                    'admin'       => 1,
                    'icon'        => 'fa-address-book',
                    'sequence'    => 4040,
                    'public'      => 0,
                    'readonly'    => 0,
                    'root'        => 1,
                    'disabled'    => 0,
                    'admin_id'    => 1,
                ],
                [
                    'database_id' => $databaseId,
                    'name'        => 'cover-letter',
                    'table'       => 'cover_letters',
                    'title'       => 'Cover Letter',
                    'plural'      => 'Cover Letters',
                    'guest'       => 0,
                    'user'        => 0,
                    'admin'       => 1,
                    'icon'        => 'fa-file-text',
                    'sequence'    => 4050,
                    'public'      => 0,
                    'readonly'    => 0,
                    'root'        => 1,
                    'disabled'    => 0,
                    'admin_id'    => 1,
                ],
                [
                    'database_id' => $databaseId,
                    'name'        => 'event',
                    'table'       => 'events',
                    'title'       => 'Event',
                    'plural'      => 'Events',
                    'guest'       => 0,
                    'user'        => 0,
                    'admin'       => 1,
                    'icon'        => 'fa-calendar',
                    'sequence'    => 4060,
                    'public'      => 0,
                    'readonly'    => 0,
                    'root'        => 1,
                    'disabled'    => 0,
                    'admin_id'    => 1,
                ],
                [
                    'database_id' => $databaseId,
                    'name'        => 'industry',
                    'table'       => 'industries',
                    'title'       => 'Industry',
                    'plural'      => 'Industries',
                    'guest'       => 0,
                    'user'        => 0,
                    'admin'       => 1,
                    'icon'        => 'fa-industry',
                    'sequence'    => 4070,
                    'public'      => 0,
                    'readonly'    => 0,
                    'root'        => 1,
                    'disabled'    => 0,
                    'admin_id'    => 1,
                ],
                [
                    'database_id' => $databaseId,
                    'name'        => 'job-board',
                    'table'       => 'job_boards',
                    'title'       => 'Job Board',
                    'plural'      => 'Job Boards',
                    'guest'       => 0,
                    'user'        => 0,
                    'admin'       => 1,
                    'icon'        => 'fa-clipboard',
                    'sequence'    => 4080,
                    'public'      => 0,
                    'readonly'    => 0,
                    'root'        => 1,
                    'disabled'    => 0,
                    'admin_id'    => 1,
                ],
                [
                    'database_id' => $databaseId,
                    'name'        => 'note',
                    'table'       => 'notes',
                    'title'       => 'Note',
                    'plural'      => 'Notes',
                    'guest'       => 0,
                    'user'        => 0,
                    'admin'       => 1,
                    'icon'        => 'fa-sticky-note',
                    'sequence'    => 4090,
                    'public'      => 0,
                    'readonly'    => 0,
                    'root'        => 1,
                    'disabled'    => 0,
                    'admin_id'    => 1,
                ],
                [
                    'database_id' => $databaseId,
                    'name'        => 'recruiter',
                    'table'       => 'recruiters',
                    'title'       => 'Recruiter',
                    'plural'      => 'Recruiters',
                    'guest'       => 0,
                    'user'        => 0,
                    'admin'       => 1,
                    'icon'        => 'fa-handshake',
                    'sequence'    => 4100,
                    'public'      => 0,
                    'readonly'    => 0,
                    'root'        => 1,
                    'disabled'    => 0,
                    'admin_id'    => 1,
                ],
                [
                    'database_id' => $databaseId,
                    'name'        => 'reference',
                    'table'       => 'references',
                    'title'       => 'Reference',
                    'plural'      => 'References',
                    'guest'       => 0,
                    'user'        => 0,
                    'admin'       => 1,
                    'icon'        => 'fa-address-card',
                    'sequence'    => 4110,
                    'public'      => 0,
                    'readonly'    => 0,
                    'root'        => 1,
                    'disabled'    => 0,
                    'admin_id'    => 1,
                ],
                [
                    'database_id' => $databaseId,
                    'name'        => 'resume',
                    'table'       => 'resumes',
                    'title'       => 'Resume',
                    'plural'      => 'Resumes',
                    'guest'       => 0,
                    'user'        => 0,
                    'admin'       => 1,
                    'icon'        => 'fa-file',
                    'sequence'    => 4120,
                    'public'      => 0,
                    'readonly'    => 0,
                    'root'        => 1,
                    'disabled'    => 0,
                    'admin_id'    => 1,
                ],
            ];

            Resource::insert($data);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('dictionary_db')->dropIfExists('dictionary_sections');
    }
};
