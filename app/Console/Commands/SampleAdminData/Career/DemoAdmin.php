<?php

namespace App\Console\Commands\SampleAdminData\Career;

use App\Models\Career\Application;
use App\Models\Career\ApplicationSkill;
use App\Models\Career\Communication;
use App\Models\Career\Company;
use App\Models\Career\CompanyContact;
use App\Models\Career\Contact;
use App\Models\Career\CoverLetter;
use App\Models\Career\Event;
use App\Models\Career\Note;
use App\Models\Career\Reference;
use App\Models\Career\Resume;
use App\Models\Scopes\AdminGlobalScope;
use App\Models\System\Admin;
use App\Models\System\AdminAdminGroup;
use Illuminate\Console\Command;
use function Laravel\Prompts\text;

class DemoAdmin extends Command
{
    const USERNAME = 'demo-admin';

    protected $demo = 1;
    protected $silent = 0;

    protected $adminId = null;

    protected $applicationId = [];
    protected $companyId = [];
    protected $contactId = [];

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:init-' . self::USERNAME . '-career {--demo=1} {--silent}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will populate the career database with initial data for admin ' . self::USERNAME . '.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // get the admin
        if (!$admin = Admin::where('username', self::USERNAME)->first()) {
            echo PHP_EOL . 'Admin `' . self::USERNAME . '` not found.' . PHP_EOL . PHP_EOL;
            die;
        }

        $this->adminId = $admin->id;

        if (!$this->silent) {
            echo PHP_EOL . 'adminId: ' . $this->adminId . PHP_EOL;
            $dummy = text('Hit Enter to continue or Ctrl-C to cancel');
        }

        // career
        $this->insertCareerCompanies();
        $this->insertCareerContacts();
        $this->insertCareerReferences();
        $this->insertCareerResumes();
        $this->insertCareerApplications();
        $this->insertCareerCoverLetters();
        $this->insertCareerCommunications();
        $this->insertCareerEvents();
        $this->insertCareerNotes();
        $this->insertCareerApplicationSkill();
        $this->insertCareerCompanyContacts();
    }

    protected function insertCareerApplications(): void
    {
        echo self::USERNAME . ": Inserting into Career\\Application ...\n";

        $this->applicationId = [];
        $maxId = Contact::withoutGlobalScope(AdminGlobalScope::class)->max('id');
        for ($i=1; $i<=23; $i++) {
            $this->applicationId[$i] = ++$maxId;
        }

        $data = [
            [
                'id'                     => $this->applicationId[1],
                'company_id'             => $this->companyId[46],
                'role'                   => 'Full-Stack Software Engineer – PHP',
                'active'                 => 1,
                'post_date'              => '2025-09-22',
                'apply_date'             => null,
                'compensation_min'       => 125000,
                'compensation_max'       => 140000,
                'compensation_unit_id'   => 2,     // 1-hour, 2-year, 3-month, 4-week, 5-day, 6-project
                'job_duration_type_id'   => 1,     // 1-Permanent, 2-Temporary, 3-Intermittent
                'job_employment_type_id' => 1,     // 1-Full-time, 2-Part-time, 5-Contract
                'job_location_type_id'   => 3,     // 1-On-site, 2-Hybrid, 3-Remote
                'city'                   => null,
                'state_id'               => null,
                'country_id'             => 237,
                'w2'                     => 0,
                'relocation'             => 0,
                'benefits'               => 0,
                'vacation'               => 0,
                'health'                 => 0,
                'job_board_id'           => 8,     // 1-Dice, 2-Indeed, 6-Larajobs, 8-LinkedId, 9-Monster, 10-SimpyHired, 11-ZipRecrueter
                'link'                   => 'https://www.linkedin.com/jobs/view/4303651950',
                'link_name'              => 'LinkedIn',
            ],
            [
                'id'                     => $this->applicationId[2],
                'company_id'             => $this->companyId[47],
                'role'                   => 'Senior Software Engineer - Full-Stack Developer',
                'active'                 => 1,
                'post_date'              => '2025-09-22',
                'apply_date'             => null,
                'compensation_min'       => null,
                'compensation_max'       => null,
                'compensation_unit'      => null,  // 1-hour, 2-year, 3-month, 4-week, 5-day, 6-project
                'job_duration_type_id'   => 1,     // 1-Permanent, 2-Temporary, 3-Intermittent
                'job_employment_type_id' => 1,     // 1-Full-time, 2-Part-time, 5-Contract
                'job_location_type_id'   => 3,     // 1-On-site, 2-Hybrid, 3-Remote
                'city'                   => 'Nashville',
                'state_id'               => 48,
                'country_id'             => 237,
                'w2'                     => 0,
                'relocation'             => 0,
                'benefits'               => 0,
                'vacation'               => 0,
                'health'                 => 0,
                'job_board_id'           => 8,     // 1-Dice, 2-Indeed, 6-Larajobs, 8-LinkedId, 9-Monster, 10-SimpyHired, 11-ZipRecrueter
                'link'                   => 'https://www.indeed.com/viewjob?jk=fcf10d24947f906b&from=shareddesktop_copy',
                'link_name'              => 'Indeed',
            ],
            [
                'id'                     => $this->applicationId[3],
                'company_id'             => $this->companyId[48],
                'role'                   => 'Staff Software Engineer (Fullstack - React/Laravel)',
                'active'                 => 1,
                'post_date'              => '2025-09-22',
                'apply_date'             => null,
                'compensation_min'       => 101653,
                'compensation_max'       => 151015,
                'compensation_unit'      => 2,     // 1-hour, 2-year, 3-month, 4-week, 5-day, 6-project
                'job_duration_type_id'   => 1,     // 1-Permanent, 2-Temporary, 3-Intermittent
                'job_employment_type_id' => 1,     // 1-Full-time, 2-Part-time, 5-Contract
                'job_location_type_id'   => 3,     // 1-On-site, 2-Hybrid, 3-Remote
                'city'                   => 'Woodstock',
                'state_id'               => 33,
                'country_id'             => 237,
                'w2'                     => 0,
                'relocation'             => 0,
                'benefits'               => 0,
                'vacation'               => 0,
                'health'                 => 0,
                'job_board_id'           => 8,     // 1-Dice, 2-Indeed, 6-Larajobs, 8-LinkedId, 9-Monster, 10-SimpyHired, 11-ZipRecrueter
                'link'                   => 'https://www.indeed.com/viewjob?jk=fcf10d24947f906b&from=shareddesktop_copy',
                'link_name'              => 'Indeed',
            ],
        ];

        if (!empty($data)) {
            Application::insert($this->additionalColumns($data, true, $this->adminId, ['demo' => $this->demo], boolval($this->demo)));
        }
    }

    protected function insertCareerApplicationSkill(): void
    {
        echo self::USERNAME . ": Inserting into Career\\ApplicationSkill ...\n";

        $data = [
            /*
            [
                'application_id'         => $this->applicationId[1],
                'name'                   => '',
                'level'                  => 5,
                'dictionary_category_id' => null,
                'dictionary_id_term_id'  => null,
                'start_year'             => 2020,
                'end_year'               => 2055,
                'years'                  => 5,
            ]
            */
        ];

        if (!empty($data)) {
            ApplicationSkill::insert($this->additionalColumns($data, true, $this->adminId, ['demo' => $this->demo], boolval($this->demo)));
        }
    }

    protected function insertCareerCompanies(): void
    {
        echo self::USERNAME . ": Inserting into Career\\Company ...\n";

        $this->companyId = [];
        $maxId = Company::withoutGlobalScope(AdminGlobalScope::class)->max('id');
        for ($i=1; $i<=84; $i++) {
            $this->companyId[$i] = ++$maxId;
        }

        $data = [
            [ 'id' => $this->companyId[1],   'name' => 'CHOAM',                                'slug' => 'choam',                                'industry_id' => 11,   'city' => null,                'state_id' => 10,   'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[2],   'name' => 'ACME Corp.',                           'slug' => 'acme-corp',                            'industry_id' => 11,   'city' => null,                'state_id' => null, 'country_id' => null, 'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[3],   'name' => 'Randstad',                             'slug' => 'randstad',                             'industry_id' => 11,   'city' => null,                'state_id' => 24,   'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[4],   'name' => 'Sirius Cybernetics Corporation',       'slug' => 'sirius-cybernetics-corporation',       'industry_id' => 11,   'city' => null,                'state_id' => 24,   'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[5],   'name' => 'MomCorp',                              'slug' => 'momcorp',                              'industry_id' => 11,   'city' => null,                'state_id' => null, 'country_id' => null, 'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[6],   'name' => 'Rich Industries',                      'slug' => 'rich-industries',                      'industry_id' => 11,   'city' => null,                'state_id' => null, 'country_id' => null, 'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[7],   'name' => 'Soylent Corporation',                  'slug' => 'soylent-corporation',                  'industry_id' => 4,    'city' => null,                'state_id' => 34,   'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[8],   'name' => 'Very Big Corporation of America',      'slug' => 'very-big-corporation-of-america',      'industry_id' => 11,   'city' => null,                'state_id' => null, 'country_id' => null, 'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[9],   'name' => 'Frobozz Magic Co.',                    'slug' => 'frobozz-magic-co',                     'industry_id' => 11,   'city' => null,                'state_id' => null, 'country_id' => null, 'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[10],  'name' => 'Warbucks Industries',                  'slug' => 'warbucks-industries',                  'industry_id' => 11,   'city' => null,                'state_id' => 24,   'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[11],  'name' => 'Tyrell Corp.',                         'slug' => 'tyrell-corp',                          'industry_id' => 11,   'city' => null,                'state_id' => 24,   'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[12],  'name' => 'Initech',                              'slug' => 'initech',                              'industry_id' => 11,   'city' => null,                'state_id' => null, 'country_id' => null, 'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[13],  'name' => 'Wayne Enterprises',                    'slug' => 'wayne-enterprises',                    'industry_id' => 11,   'city' => null,                'state_id' => null, 'country_id' => null, 'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[14],  'name' => 'Virtucon',                             'slug' => 'virtucon',                             'industry_id' => 11,   'city' => null,                'state_id' => null, 'country_id' => null, 'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[15],  'name' => 'Globex',                               'slug' => 'globex',                               'industry_id' => 11,   'city' => null,                'state_id' => null, 'country_id' => null, 'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[16],  'name' => 'Umbrella Corp.',                       'slug' => 'umbrella-corp',                        'industry_id' => 11,   'city' => null,                'state_id' => 24,   'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[17],  'name' => 'Stark Industries',                     'slug' => 'start-industries',                     'industry_id' => 11,   'city' => null,                'state_id' => 24,   'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[18],  'name' => 'Clampett Oil',                         'slug' => 'clampett-oil',                         'industry_id' => 11,   'city' => null,                'state_id' => 24,   'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[19],  'name' => 'Oceanic Airlines',                     'slug' => 'oceanic-airlines',                     'industry_id' => 11,   'city' => null,                'state_id' => null, 'country_id' => null, 'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[20],  'name' => 'Yoyodyne Propulsion Sys.',             'slug' => 'yoyodyne-propulsion-sys',              'industry_id' => 11,   'city' => null,                'state_id' => null, 'country_id' => null, 'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[21],  'name' => 'Cyberdyne Systems Corp.',              'slug' => 'cyberdyne-systems-corp',               'industry_id' => 11,   'city' => null,                'state_id' => null, 'country_id' => null, 'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[22],  'name' => 'd\'Anconia Copper',                    'slug' => 'danconia-copper',                      'industry_id' => 11,   'city' => null,                'state_id' => 44,   'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[23],  'name' => 'Kiki\'s Delivery Service',             'slug' => 'kikis-delivery-service',               'industry_id' => 11,   'city' => null,                'state_id' => null, 'country_id' => null, 'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[24],  'name' => 'Gringotts',                            'slug' => 'gringotts',                            'industry_id' => 11,   'city' => null,                'state_id' => null, 'country_id' => null, 'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[25],  'name' => 'Oscorp',                               'slug' => 'oscorp',                               'industry_id' => 11,   'city' => null,                'state_id' => null, 'country_id' => null, 'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[26],  'name' => 'Nakatomi Trading Corp.',               'slug' => 'nakatomi-trading-corp',                'industry_id' => 11,   'city' => null,                'state_id' => null, 'country_id' => null, 'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[27],  'name' => 'Spacely Space Sprockets',              'slug' => 'spacely-space-sprockets',              'industry_id' => 11,   'city' => null,                'state_id' => null, 'country_id' => null, 'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[28],  'name' => 'International Genetic Technologies',   'slug' => 'international-genetic-technologies',   'industry_id' => 11,   'city' => null,                'state_id' => null, 'country_id' => null, 'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[29],  'name' => 'Wonka Industries',                     'slug' => 'wonka-industries',                     'industry_id' => 10,   'city' => null,                'state_id' => 6,    'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[30],  'name' => 'Weyland-Yutani',                       'slug' => 'weylandyutani',                        'industry_id' => 11,   'city' => null,                'state_id' => 22,   'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[31],  'name' => 'Pierce & Pierce',                      'slug' => 'pierce-and-pierce',                    'industry_id' => 11,   'city' => null,                'state_id' => 11,   'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[32],  'name' => 'Compu-Global-Hyper-Mega-Net',          'slug' => 'compu-global-hyper-mega-net',          'industry_id' => 11,   'city' => null,                'state_id' => 22,   'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[33],  'name' => 'Silver Shamrock Novelties',            'slug' => 'silver-shamrock-novelties',            'industry_id' => 11,   'city' => null,                'state_id' => null, 'country_id' => null, 'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[34],  'name' => 'Ollivander\'s Wand Shop',              'slug' => 'ollivanders-wand-shop',                'industry_id' => 11,   'city' => null,                'state_id' => null, 'country_id' => null, 'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[35],  'name' => 'Gekko and Co.',                        'slug' => 'gekko-and-co',                         'industry_id' => 11,   'city' => null,                'state_id' => 44,   'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[36],  'name' => 'Cheers',                               'slug' => 'cheers',                               'industry_id' => 11,   'city' => null,                'state_id' => null, 'country_id' => null, 'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[37],  'name' => 'Callister Inc',                        'slug' => 'callister-inc',                        'industry_id' => 11,   'city' => null,                'state_id' => null, 'country_id' => null, 'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[38],  'name' => 'The Krusty Krab',                      'slug' => 'the-krusty-krab',                      'industry_id' => 11,   'city' => null,                'state_id' => 31,   'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[39],  'name' => 'Good Burger',                          'slug' => 'good-burger',                          'industry_id' => 11,   'city' => null,                'state_id' => null, 'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[40],  'name' => 'Quick Stop',                           'slug' => 'quick-stop',                           'industry_id' => 11,   'city' => null,                'state_id' => null, 'country_id' => null, 'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[41],  'name' => 'Burns Industries',                     'slug' => 'burns-industries',                     'industry_id' => 11,   'city' => null,                'state_id' => null, 'country_id' => null, 'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[42],  'name' => 'Buy n\' Large',                        'slug' => 'byu-n-large',                          'industry_id' => 11,   'city' => null,                'state_id' => null, 'country_id' => null, 'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[43],  'name' => 'Curl Up and Dye',                      'slug' => 'curl-up-and-dye',                      'industry_id' => 11,   'city' => null,                'state_id' => 11,   'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[44],  'name' => 'Bushwood Country Club',                'slug' => 'bushwood-country-club',                'industry_id' => 11,   'city' => null,                'state_id' => null, 'country_id' => null, 'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[45],  'name' => 'Dunder Mifflin Paper Company, Inc',    'slug' => 'dunder-mifflin-paper-company-inc',     'industry_id' => 11,   'city' => null,                'state_id' => null, 'country_id' => null, 'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[46],  'name' => 'Prestige Worldwide',                   'slug' => 'prestige-worldwide',                   'industry_id' => 11, 'city' => null,                  'state_id' => null, 'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[47],  'name' => 'Brawndo',                              'slug' => 'brwando',                              'industry_id' => 29, 'city' => null,                  'state_id' => null, 'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[48],  'name' => 'Aperture Science, Inc.',               'slug' => 'aperture-science-inc',                 'industry_id' => 11, 'city' => null,                  'state_id' => null, 'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[49],  'name' => 'Lacuna, Inc.',                         'slug' => 'lacuna-inc',                           'industry_id' => 11, 'city' => null,                  'state_id' => null, 'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[50],  'name' => 'Monsters, Inc.',                       'slug' => 'monsters-inc',                         'industry_id' => 11, 'city' => 'Chantilly',           'state_id' => 47,   'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[51],  'name' => 'Los Pollos Hermanos',                  'slug' => 'los-pollos-hermanos',                  'industry_id' => 11, 'city' => 'Santa Monica',        'state_id' => 5,    'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[52],  'name' => 'SPECTRE',                              'slug' => 'spectre',                              'industry_id' => 11, 'city' => 'Knoxville',           'state_id' => 43,   'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[53],  'name' => 'Pied Piper',                           'slug' => 'pied-piper',                           'industry_id' => 11, 'city' => null,                  'state_id' => null, 'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[54],  'name' => 'The Daily Planet',                     'slug' => 'the-daily-planet',                     'industry_id' => 11, 'city' => 'Bridgewater',         'state_id' => 31,   'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[55],  'name' => 'Planet Express, Inc.',                 'slug' => 'planet-express-inc',                   'industry_id' => 11, 'city' => 'Columbus',            'state_id' => 36,   'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[56],  'name' => 'InGen',                                'slug' => 'ingen',                                'industry_id' => 11, 'city' => 'Washington',          'state_id' => 9,    'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[57],  'name' => 'Outdoor Man',                          'slug' => 'outdoor-man',                          'industry_id' => 11, 'city' => null,                  'state_id' => null, 'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[58],  'name' => 'Empire Records',                       'slug' => 'empire-records',                       'industry_id' => 11, 'city' => 'Thousand Oaks',       'state_id' => 5,    'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[59],  'name' => 'Pendant Publishing',                   'slug' => 'pendant-publishing',                   'industry_id' => 11, 'city' => null,                  'state_id' => null, 'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[60],  'name' => 'Vandelay Industries',                  'slug' => 'vandelay-industries',                  'industry_id' => 11, 'city' => null,                  'state_id' => null, 'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[61],  'name' => 'WKRP',                                 'slug' => 'wkrp',                                 'industry_id' => 11, 'city' => null,                  'state_id' => null, 'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[62],  'name' => 'Sterling Cooper Advertising Agency',   'slug' => 'sterling-copper-advertising-agency',   'industry_id' => 11, 'city' => null,                  'state_id' => null, 'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[63],  'name' => 'Championship Vinyl',                   'slug' => 'championship-vinyl',                   'industry_id' => 11, 'city' => 'Altamonte Springs',   'state_id' => 10,   'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[64],  'name' => 'Bluth Company',                        'slug' => 'bluth-company',                        'industry_id' => 11, 'city' => 'St. Louis Park',      'state_id' => 24,   'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[65],  'name' => 'Duff Beer',                            'slug' => 'duff-beer',                            'industry_id' => 11, 'city' => 'Ogden',               'state_id' => 45,   'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[66],  'name' => 'Central Perk',                         'slug' => 'central-perk',                         'industry_id' => 11, 'city' => 'Washington',          'state_id' => 9,    'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[67],  'name' => 'Ghostbusters',                         'slug' => 'ghostbusters',                         'industry_id' => 11, 'city' => null,                  'state_id' => null, 'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[68],  'name' => 'SCP Foundation',                       'slug' => 'scp-foundation',                       'industry_id' => 11, 'city' => null,                  'state_id' => null, 'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[69],  'name' => 'Shinra Electric Power Company',        'slug' => 'shinra-electric-power-company',        'industry_id' => 11, 'city' => 'Bedford',             'state_id' => 44,   'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[70],  'name' => 'Tian Industries',                      'slug' => 'tina-industries',                      'industry_id' => 11, 'city' => null,                  'state_id' => null, 'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[71],  'name' => 'RDA Corporation',                      'slug' => 'rda-corporation',                      'industry_id' => 11, 'city' => 'Mason',               'state_id' => 36,   'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[72],  'name' => 'InterGalactic Banking Clan',           'slug' => 'intergalactic-banking-clan',           'industry_id' => 11, 'city' => null,                  'state_id' => null, 'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[73],  'name' => 'The Bank of Evil',                     'slug' => 'the-bank-of-evil',                     'industry_id' => 11, 'city' => null,                  'state_id' => null, 'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[74],  'name' => 'Parallax Corporation',                 'slug' => 'parallax-corporation',                 'industry_id' => 11, 'city' => 'Salt Lake City',      'state_id' => 45,   'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[75],  'name' => 'Mitch and Murray',                     'slug' => 'mitch-and-murray',                     'industry_id' => 11, 'city' => 'Indianapolis',        'state_id' => 15,   'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[76],  'name' => 'Megadodo Publications',                'slug' => 'megadodo-publications',                'industry_id' => 11, 'city' => null,                  'state_id' => null, 'country_id' => null, 'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[77],  'name' => 'Multi National United',                'slug' => 'multi-national-united',                'industry_id' => 11, 'city' => 'Milwaukee',           'state_id' => 50,   'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[78],  'name' => 'Crimson Permanent Assurance',          'slug' => 'crimson-permanent-assurance',          'industry_id' => 11, 'city' => null,                  'state_id' => null, 'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[79],  'name' => 'Spectacular Optical',                  'slug' => 'spectacular-optical',                  'industry_id' => 11, 'city' => 'Austin',              'state_id' => 44,   'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[80],  'name' => 'Resources Development Administration', 'slug' => 'resources-development-administration', 'industry_id' => 11, 'city' => 'Plano',               'state_id' => 44,   'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[81],  'name' => 'Adventureland',                        'slug' => 'adventureland',                        'industry_id' => 11, 'city' => null,                  'state_id' => null, 'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[82],  'name' => 'Duke & Duke',                          'slug' => 'duke-and-duke',                        'industry_id' => 11, 'city' => null,                  'state_id' => null, 'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[83],  'name' => 'Lunar Industries',                     'slug' => 'lunar-industries',                     'industry_id' => 11, 'city' => 'Baltimore',           'state_id' => 21,   'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[84],  'name' => 'McDowell\'s',                          'slug' => 'mcdowells',                            'industry_id' => 11, 'city' => 'Idaho Falls',         'state_id' => 13,   'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            //[ 'id' => 1,                     'name' => '',                                     'slug' => '',                                     'industry_id' => 11, 'city' => null,                  'state_id' => null, 'country_id' => null, 'logo' => null, 'logo_small'  => null ],
        ];

        if (!empty($data)) {
            Company::insert($this->additionalColumns($data, true, $this->adminId, ['demo' => $this->demo], boolval($this->demo)));
        }
    }

    protected function insertCareerCompanyContacts(): void
    {
        echo self::USERNAME . ": Inserting into Career\\CompanyContact ...\n";

        $data = [
            [ 'company_id' => $this->companyId[1],  'contact_id' => $this->contactId[1],  'active' => 1 ],
            [ 'company_id' => $this->companyId[2],  'contact_id' => $this->contactId[2],  'active' => 1 ],
            [ 'company_id' => $this->companyId[4],  'contact_id' => $this->contactId[3],  'active' => 1 ],
            [ 'company_id' => $this->companyId[6],  'contact_id' => $this->contactId[4],  'active' => 1 ],
            [ 'company_id' => $this->companyId[7],  'contact_id' => $this->contactId[5],  'active' => 1 ],
            [ 'company_id' => $this->companyId[8],  'contact_id' => $this->contactId[6],  'active' => 1 ],
            [ 'company_id' => $this->companyId[9],  'contact_id' => $this->contactId[10], 'active' => 1 ],
            [ 'company_id' => $this->companyId[9],  'contact_id' => $this->contactId[11], 'active' => 1 ],
            [ 'company_id' => $this->companyId[9],  'contact_id' => $this->contactId[12], 'active' => 1 ],
            [ 'company_id' => $this->companyId[9],  'contact_id' => $this->contactId[13], 'active' => 1 ],
            [ 'company_id' => $this->companyId[2],  'contact_id' => $this->contactId[14], 'active' => 1 ],
            [ 'company_id' => $this->companyId[12], 'contact_id' => $this->contactId[16], 'active' => 1 ],
            [ 'company_id' => $this->companyId[13], 'contact_id' => $this->contactId[17], 'active' => 1 ],
            [ 'company_id' => $this->companyId[14], 'contact_id' => $this->contactId[8],  'active' => 1 ],
            [ 'company_id' => $this->companyId[15], 'contact_id' => $this->contactId[19], 'active' => 1 ],
            [ 'company_id' => $this->companyId[21], 'contact_id' => $this->contactId[20], 'active' => 1 ],
            [ 'company_id' => $this->companyId[22], 'contact_id' => $this->contactId[21], 'active' => 1 ],
            [ 'company_id' => $this->companyId[23], 'contact_id' => $this->contactId[23], 'active' => 1 ],
        ];

        if (!empty($data)) {
            CompanyContact::insert($this->additionalColumns($data));
        }
    }

    protected function insertCareerContacts(): void
    {
        echo self::USERNAME . ": Inserting into Career\\Contact ...\n";

        $this->contactId = [];
        $maxId = Contact::withoutGlobalScope(AdminGlobalScope::class)->max('id');
        for ($i=1; $i<=23; $i++) {
            $this->contactId[$i] = ++$maxId;
        }

        $data = [
            [ 'id' => $this->contactId[1],   'name' => 'Ted Lasso',               'slug' => 'ted-lasso',     'phone' => null,	            'phone_label' => null,   'email' => 'Chad.Vasquez@CyberCoders.com',         'email_label' => 'work' ],
            [ 'id' => $this->contactId[2],   'name' => 'Moira Rose',              'slug' => 'moira-rose',    'phone' => null,	            'phone_label' => null,   'email' => 'lyman.ambrose@mondo.com',              'email_label' => 'work' ],
            [ 'id' => $this->contactId[3],   'name' => 'Joey Tribbiani',          'slug' => 'joey-tribbiani',    'phone' => null,               'phone_label' => null,   'email' => 'milesb@infinity-cs.com',               'email_label' => 'work' ],
            [ 'id' => $this->contactId[4],   'name' => 'Stewie Griffin',          'slug' => 'stewie-griffin',       'phone' => null,	            'phone_label' => null,   'email' => 'jolly.nibu@artech.com',                'email_label' => 'work' ],
            [ 'id' => $this->contactId[5],   'name' => 'Edmund Blackadder',       'slug' => 'edmund-blackadder',  'phone' => null,	            'phone_label' => null,   'email' => null,                                   'email_label' => null   ],
            [ 'id' => $this->contactId[6],   'name' => 'David Brent',             'slug' => 'david-brent',  'phone' => null,	            'phone_label' => null,   'email' => 'jluehmann@horizontal.com',             'email_label' => 'work' ],
            [ 'id' => $this->contactId[7],   'name' => 'Troy Barnes',             'slug' => 'troy-barnes',      'phone' => null,	            'phone_label' => null,   'email' => null,                                   'email_label' => null   ],
            [ 'id' => $this->contactId[8],   'name' => 'Selina Meyer',            'slug' => 'selina-meyer',      'phone' => null,               'phone_label' => null,   'email' => null,                                   'email_label' => null   ],
            [ 'id' => $this->contactId[9],   'name' => 'Blanche Devereaux',       'slug' => 'blanche-devereaux', 'phone' => null,               'phone_label' => null,   'email' => null,                                   'email_label' => null   ],
            [ 'id' => $this->contactId[10],  'name' => 'Patsy Stone',             'slug' => 'patsy-stone',     'phone' => null,               'phone_label' => null,   'email' => null,                                   'email_label' => null   ],
            [ 'id' => $this->contactId[11],  'name' => 'Tracy Jordan',            'slug' => 'tracy-jordan',  'phone' => null,	            'phone_label' => null,   'email' => null,                                   'email_label' => null   ],
            [ 'id' => $this->contactId[12],  'name' => 'Father Dougal Mcguire',   'slug' => 'father-dougal-mcguire',  'phone' => null,	            'phone_label' => null,   'email' => null,                                   'email_label' => null   ],
            [ 'id' => $this->contactId[13],  'name' => 'Malcolm Tucker',          'slug' => 'malcolm-tucker',     'phone' => null,	            'phone_label' => null,   'email' => null,                                   'email_label' => null   ],
            [ 'id' => $this->contactId[14],  'name' => 'Del Boy Trotter',         'slug' => 'del-boy-trotter',  'phone' => null,	            'phone_label' => null,   'email' => 'dylan.rogelstad@mail.cybercoders.com', 'email_label' => 'work' ],
            [ 'id' => $this->contactId[15],  'name' => 'Arnold J Rimmer',         'slug' => 'arnold-j-rimmer',    'phone' => null,	            'phone_label' => null,   'email' => null,                                   'email_label' => null   ],
            [ 'id' => $this->contactId[16],  'name' => 'Bob Belcher',             'slug' => 'bob-belcher',      'phone' => null,               'phone_label' => null,   'email' => 'tlesnick@trovasearch.com',             'email_label' => 'work' ],
            [ 'id' => $this->contactId[17],  'name' => 'Tahani Al-Jamil',         'slug' => 'tahani-al-jamil',         'phone' => null,               'phone_label' => null,   'email' => 'Ciara.Monahan@insightglobal.com',      'email_label' => 'work' ],
            [ 'id' => $this->contactId[18],  'name' => 'Norman Stanley Fletcher', 'slug' => 'norman-stanley-fletcher', 'phone' => null,	            'phone_label' => null,   'email' => 'rob@yscouts.com',                      'email_label' => 'work' ],
            [ 'id' => $this->contactId[19],  'name' => 'Richard Richard',         'slug' => 'richard-richard',         'phone' => null,	            'phone_label' => null,   'email' => null,                                   'email_label' => null   ],
            [ 'id' => $this->contactId[20],  'name' => 'Jim Royle',               'slug' => 'jim-royle',               'phone' => '(774) 555-1614',   'phone_label' => 'work', 'email' => 'kelsey.higgins@klaviyo.com',           'email_label' => 'work' ],
            [ 'id' => $this->contactId[21],  'name' => 'Jill Tyrell',             'slug' => 'jill-tyrell',             'phone' => null,	            'phone_label' => null,   'email' => 'coleman@lendflow.io',                  'email_label' => 'work' ],
            [ 'id' => $this->contactId[22],  'name' => 'Archie Bunker',           'slug' => 'archie-bunker',      'phone' => null,	            'phone_label' => null,   'email' => null,                                   'email_label' => null   ],
            [ 'id' => $this->contactId[23],  'name' => 'Willy Gilligan',          'slug' => 'willy-gilligan',    'phone' => null,	            'phone_label' => null,   'email' => null,                                   'email_label' => null   ],
            //[ 'id' => 1,                     'name' => '',                        'slug' => '',                 'phone' => null,	            'phone_label' => null,   'email' => null,                                   'email_label' => null   ],
        ];

        if (!empty($data)) {
            Contact::insert($this->additionalColumns($data, true, $this->adminId, ['demo' => $this->demo], boolval($this->demo)));
        }
    }

    protected function insertCareerCommunications(): void
    {
        echo self::USERNAME . ": Inserting into Career\\Communication ...\n";

        $data = [
            /*
            [
                'application_id' => $this->applicationId[1],
                'subject'        => '',
                'date'           => '0000-00-00',
                'time'           => '00:00:00',
                'body'           => null,
            ]
            */
        ];

        if (!empty($data)) {
            Communication::insert($this->additionalColumns($data, true, $this->adminId, ['demo' => $this->demo], boolval($this->demo)));
        }
    }

    protected function insertCareerCoverLetters(): void
    {
        echo self::USERNAME . ": Inserting into Career\\CoverLetter ...\n";

        $data = [
            /*
            [
                'application_id' => $this->applicationId[1],
                'date'           => '0000-00-00',
                'content'        => null,
                'description'    => null,
            ],
            */
        ];

        if (!empty($data)) {
            CoverLetter::insert($this->additionalColumns($data, true, $this->adminId, ['demo' => $this->demo], boolval($this->demo)));
        }
    }

    protected function insertCareerEvents(): void
    {
        echo self::USERNAME . ": Inserting into Career\\Event ...\n";

        $data = [
            /*
            [
                'application_id' => $this->applicationId[1],
                'subject'        => '',
                'date'           => '0000-00-00',
                'time'           => '00:00:00',
                'location'       => null,
                'description'    => null,
            ]
            */
        ];

        if (!empty($data)) {
            Event::insert($this->additionalColumns($data, true, $this->adminId, ['demo' => $this->demo], boolval($this->demo)));
        }
    }

    protected function insertCareerNotes(): void
    {
        echo self::USERNAME . ": Inserting into Career\\Note ...\n";

        $data = [
            /*
            [
                'application_id' => $this->applicationId[1],
                'subject'        => '',
                'date'           => '0000-00-00',
                'time'           => '00:00:00',
                'body'           => null,
            ]
            */
        ];

        if (!empty($data)) {
            Note::insert($this->additionalColumns($data, true, $this->adminId, ['demo' => $this->demo], boolval($this->demo)));
        }
    }

    protected function insertCareerReferences(): void
    {
        echo self::USERNAME . ": Inserting into Career\\Reference ...\n";

        $data = [
            [ 'name' => 'George Costanza', 'slug' => 'george-costanza', 'friend' => 0, 'family' => 0, 'coworker' => 0, 'supervisor' => 1, 'subordinate' => 0, 'professional' => 0, 'other' => 0, 'company_id' => 85,   'street' => null,                    'street2' => null,  'city' => 'Loomisy',     'state_id' => 13,   'zip' => null,         'country_id' => 237, 'phone' => '(208) 555-0507', 'phone_label' => 'work',   'alt_phone' => '(208) 555-3644', 'alt_phone_label' => 'mobile', 'email' => 'kevin.hemsley@inl.gov',          'email_label' => 'work', 'alt_email' => null,                  'alt_email_label' => null,    'birthday' => null,         'link' => 'https://www.linkedin.com/in/kevin-hemsley-a30740132/' ],
            [ 'name' => 'Ron Swanson',     'slug' => 'ron-swanson',     'friend' => 0, 'family' => 0, 'coworker' => 0, 'supervisor' => 1, 'subordinate' => 0, 'professional' => 0, 'other' => 0, 'company_id' => 85,   'street' => null,                    'street2' => null,  'city' => null,          'state_id' => null, 'zip' => null,         'country_id' => 237, 'phone' => '(913) 555-5399', 'phone_label' => null,     'alt_phone' => null,             'alt_phone_label' => null,     'email' => 'paul.davis@inl.gov',             'email_label' => 'work', 'alt_email' => 'prtdavis2@yahoo.com', 'alt_email_label' => 'home',  'birthday' => null,         'link' => null ],
            [ 'name' => 'Homer Simpson',   'slug' => 'homer-simpson',   'friend' => 0, 'family' => 0, 'coworker' => 1, 'supervisor' => 0, 'subordinate' => 0, 'professional' => 0, 'other' => 0, 'company_id' => 85,   'street' => null,                    'street2' => null,  'city' => null,          'state_id' => 33,   'zip' => null,         'country_id' => 237, 'phone' => '(917) 555-6003', 'phone_label' => 'home',   'alt_phone' => null,             'alt_phone_label' => null,     'email' => 'akahen@live.com',                'email_label' => 'home', 'alt_email' => 'alen.kahen@inl.com',  'alt_email_label' => 'work',  'birthday' => null,         'link' => null ],
            [ 'name' => 'Basil Fawlty',    'slug' => 'basil-fawlty',    'friend' => 0, 'family' => 0, 'coworker' => 1, 'supervisor' => 0, 'subordinate' => 0, 'professional' => 0, 'other' => 0, 'company_id' => 85,   'street' => null,                    'street2' => null,  'city' => null,          'state_id' => null, 'zip' => null,         'country_id' => 237, 'phone' => '(603) 555-2707', 'phone_label' => 'mobile', 'alt_phone' => '(208) 555-4280', 'alt_phone_label' => 'work',   'email' => 'nancy.gomezdominguez@inl.gov',   'email_label' => 'work', 'alt_email' => 'ngd.00@outlook.com',  'alt_email_label' => 'home',  'birthday' => null,         'link' => null ],
            [ 'name' => 'Phil Dunphy',     'slug' => 'phil-dunphy',     'friend' => 0, 'family' => 1, 'coworker' => 0, 'supervisor' => 0, 'subordinate' => 0, 'professional' => 0, 'other' => 0, 'company_id' => null, 'street' => '2678 Grant Lane',       'street2' => null,  'city' => 'Springfield', 'state_id' => 39,   'zip' => '17408-9567', 'country_id' => 237, 'phone' => '(717) 555-1215', 'phone_label' => 'home',   'alt_phone' => '(717) 555-1207', 'alt_phone_label' => 'mobile', 'email' => 'BZearfoss@aol.com',              'email_label' => 'home', 'alt_email' => null,                  'alt_email_label' => null,    'birthday' => '1942-08-20', 'link' => null ],
            [ 'name' => 'Al Bundy',        'slug' => 'al-bundy',        'friend' => 0, 'family' => 1, 'coworker' => 0, 'supervisor' => 0, 'subordinate' => 0, 'professional' => 0, 'other' => 0, 'company_id' => null, 'street' => '380 Harvey Rd.',        'street2' => null,  'city' => 'Richfield',   'state_id' => 39,   'zip' => '17404',      'country_id' => 237, 'phone' => '(717) 555-7795', 'phone_label' => 'home',   'alt_phone' => '(717) 555-1415', 'alt_phone_label' => 'mobile', 'email' => 'zearfoss@verizon.net',           'email_label' => 'home', 'alt_email' => null,                  'alt_email_label' => null,    'birthday' => '1962-07-19', 'link' => null ],
            [ 'name' => 'Herman Munster',  'slug' => 'herman-munster',  'friend' => 0, 'family' => 1, 'coworker' => 0, 'supervisor' => 0, 'subordinate' => 0, 'professional' => 0, 'other' => 0, 'company_id' => null, 'street' => '1313 Mockingbird Lane', 'street2' => null,  'city' => 'Davenport',   'state_id' => 29,   'zip' => '89521',      'country_id' => 237, 'phone' => '(775) 555-1264', 'phone_label' => 'home',   'alt_phone' => '(775) 555-0775', 'alt_phone_label' => 'mobile', 'email' => 'DZearfoss@aol.com',              'email_label' => 'home', 'alt_email' => 'dzearfoss@eigwc.com', 'alt_email_label' => 'work',  'birthday' => '1965-11-25', 'link' => null ],
            [ 'name' => 'Raymond Holt',    'slug' => 'raymond-holt',    'friend' => 0, 'family' => 1, 'coworker' => 0, 'supervisor' => 0, 'subordinate' => 0, 'professional' => 0, 'other' => 0, 'company_id' => null, 'street' => '2678 East Rd',          'street2' => null,  'city' => 'Golden Pond', 'state_id' => 39,   'zip' => '17408-9567', 'country_id' => 237, 'phone' => '(717) 555-1215', 'phone_label' => 'home',   'alt_phone' => null,             'alt_phone_label' => null,     'email' => null,                             'email_label' => null,   'alt_email' => null,                  'alt_email_label' => null,    'birthday' => '1941-09-11', 'link' => null ],
            [ 'name' => 'Charlie Kelly ',  'slug' => 'charlie-kelly',   'friend' => 1, 'family' => 0, 'coworker' => 0, 'supervisor' => 0, 'subordinate' => 0, 'professional' => 0, 'other' => 0, 'company_id' => null, 'street' => '9079 52nd Ave',         'street2' => null,  'city' => 'New London',  'state_id' => 24,   'zip' => '55362',      'country_id' => 237, 'phone' => '(763) 555-2216', 'phone_label' => 'mobile', 'alt_phone' => null,             'alt_phone_label' => null,     'email' => 'mariaelaine29@yahoo.com',        'email_label' => 'home', 'alt_email' => null,                  'alt_email_label' => null,    'birthday' => '1980-07-30', 'link' => null ],
            [ 'name' => 'Frank Reynolds',  'slug' => 'frank-reynolds',   'friend' => 1, 'family' => 0, 'coworker' => 0, 'supervisor' => 0, 'subordinate' => 0, 'professional' => 0, 'other' => 0, 'company_id' => null, 'street' => '21   Johnson Street',   'street2' => null,  'city' => 'Athens',      'state_id' => 44,   'zip' => '78130',      'country_id' => 237, 'phone' => '(830) 555-8713', 'phone_label' => 'home',   'alt_phone' => null,             'alt_phone_label' => null,     'email' => 'refugeechildrendream@yahoo.com', 'email_label' => 'home', 'alt_email' => null,                  'alt_email_label' => null,    'birthday'  => null,        'link' => null ],
        ];

        if (!empty($data)) {
            Reference::insert($this->additionalColumns($data, true, $this->adminId, ['demo' => $this->demo], boolval($this->demo)));
        }
    }

    protected function insertCareerResumes(): void
    {
        echo self::USERNAME . ": Inserting into Career\\Resume ...\n";

        $data = [
            [ 'name' => 'PHP/MySQL Web Developer',                  'date' => '2015-03-19', 'primary' => 0, 'doc_url' => 'https://www.dropbox.com/scl/fi/9avg6ve67wnoooxm3jwbx/resume.doc?rlkey=vzkdjqkuxw59nghmcf8d6v2xa&st=kjkb0kxj&dl=0',                                            'pdf_url'  => null,                                                                                                                       'public'   => 0 ],
            [ 'name' => 'Senior Web Developer',                     'date' => '2016-11-24', 'primary' => 0, 'doc_url' => 'https://www.dropbox.com/scl/fi/n313k7vveguisq3n9wbxf/craigzearfoss.docx?rlkey=3hms59ts6nwy0iqlyyh3bsw7e&st=695lhlbu&dl=0',                                    'pdf_url'  => 'https://www.dropbox.com/scl/fi/o7x78isovwo8220144mjz/craigzearfoss.pdf?rlkey=cbg59sg0jdr38qawkuzhtexu3&st=py7h358e&dl=0',  'public'   => 0 ],
            [ 'name' => 'Senior Full Stack Developer',              'date' => '2018-12-05', 'primary' => 0, 'doc_url' => 'https://www.dropbox.com/scl/fi/v83yu6f23pjtg37xs86er/craigzearfoss.docx?rlkey=m0d5vu31abn31kqmrrvirphk7&st=eaqvpj67&dl=0',                                    'pdf_url'  => null,                                                                                                                       'public'   => 0 ],
            [ 'name' => 'Senior Software Engineer',                 'date' => '2019-07-28', 'primary' => 0, 'doc_url' => 'https://www.dropbox.com/scl/fi/aq4rjtcy8lgr4p3fzk2tu/craigzearfoss.docx?rlkey=axj2g2r0blnn3fj0hgnr4zbxe&st=1wbcx7yl&dl=0',                                    'pdf_url'  => 'https://www.dropbox.com/scl/fi/3y0gbw5j1oticsvvquc10/craigzearfoss.pdf?rlkey=4mkpm023j61c7wojr10a605na&st=ckevybmz&dl=0' , 'public'   => 0 ],
            [ 'name' => 'Senior Software Engineer',                 'date' => '2020-03-21', 'primary' => 0, 'doc_url' => 'https://www.dropbox.com/scl/fi/3pw6ni7jy3ltmfston3ck/craigzearfoss.docx?rlkey=2xrhukvic3x7y1ycsdujyxp11&st=9jdigq2y&dl=0',                                    'pdf_url'  => 'https://www.dropbox.com/scl/fi/u38vtuha8j2wp8h86opim/craigzearfoss.pdf?rlkey=uiaz2lfssza7n4eeqil2yvmsr&st=vzze8s4t&dl=0',  'public'   => 0 ],
            [ 'name' => 'Senior Software Engineer',                 'date' => '2022-01-13', 'primary' => 0, 'doc_url' => 'https://www.dropbox.com/scl/fi/zdivxb8u518v58a9k2swt/craigzearfoss-extended.docx?rlkey=6tjsnn33gmoct7k3kndxquoh8&st=fy0eootp&dl=0',                           'pdf_url'  => 'https://www.dropbox.com/scl/fi/n55xem02slgzhobszsczd/craigzearfoss.docx?rlkey=0wlntvs93fkc38fsdnqmruqd4&st=eh4jrkzo&dl=0', 'public'   => 0 ],
            [ 'name' => '',                                         'date' => '2023-01-07', 'primary' => 0, 'doc_url' => 'https://www.dropbox.com/scl/fi/kczg2cht4jof2ookdrlor/craigzearfoss.docx?rlkey=fx2er17eq8a7gebkq0s4xkrp2&st=xhfr1ab1&dl=0',                                    'pdf_url'  => 'https://www.dropbox.com/scl/fi/dw5n5nwybw01i2axjwt3j/craigzearfoss.pdf?rlkey=y1gp5cuykyns4s4m1zk7ldh4o&st=dytodp4m&dl=0',  'public'   => 0 ],
            [ 'name' => 'Senior Software Engineer',                 'date' => '2025-06-09', 'primary' => 0, 'doc_url' => 'https://www.dropbox.com/scl/fi/p91cze7mplhvqoxyipq4b/craigzearfoss.docx?rlkey=d8df5ops5irfni98hp2pfkhys&st=v77425zc&dl=0',                                    'pdf_url'  => null,                                                                                                                       'public'   => 0 ],
            [ 'name' => 'Senior Software Engineer',                 'date' => '2025-06-16', 'primary' => 0, 'doc_url' => 'https://www.dropbox.com/scl/fi/eiqyia4ez7stq6pbbiukn/craigzearfoss.docx?rlkey=cpebqb9nkw20pb73yek8g8fyt&st=ggbhhl8f&dl=0',                                    'pdf_url'  => null,                                                                                                                       'public'   => 0 ],
            [ 'name' => 'Senior Software Engineer [condensed]',     'date' => '2025-06-22', 'primary' => 0, 'doc_url' => 'https://www.dropbox.com/scl/fi/uv8egj3schs5gixqdflcz/craigzearfoss.docx?rlkey=bwwjtdveev6zc08gkrv6sc07x&st=ay3bkv0u&dl=0',                                    'pdf_url'  => 'https://www.dropbox.com/scl/fi/e3rdmwiqwxg7uf443dki6/craigzearfoss.pdf?rlkey=9ltwy0ozz4nigp43h2he41vyw&st=kqsv3eg7&dl=0',  'public'   => 0 ],
            [ 'name' => 'Senior Software Engineer [streamlined]',   'date' => '2025-06-29', 'primary' => 0, 'doc_url' => 'https://www.dropbox.com/scl/fi/keqkxhobp6165za6u1nsq/craigzearfoss.docx?rlkey=tkb3q4xeug3jzef68w4spoux1&st=h0zwcdmh&dl=0',                                    'pdf_url'  => null,                                                                                                                       'public'   => 0 ],
            [ 'name' => 'Senior Full Stack Developer [prettified]', 'date' => '2025-07-07', 'primary' => 0, 'doc_url' => 'https://www.dropbox.com/scl/fi/37eb5w83od7p2kd1xrn5c/craigzearfoss.docx?rlkey=pnkdwj465jifxahahcnou1e44&st=gesg99x6&dl=0',                                    'pdf_url'  => 'https://www.dropbox.com/scl/fi/f8dwiprt5z64npnm3vcj4/craigzearfoss.pdf?rlkey=c424qxaxysdv2c4n80oium6on&st=ftooahy9&dl=0',  'public'   => 0 ],
            [ 'name' => 'Senior PHP Developer [prettified]',        'date' => '2025-07-07', 'primary' => 0, 'doc_url' => 'https://www.dropbox.com/scl/fi/7abbsyqyksq666k4s6kt5/craigzearfoss.docx?rlkey=5yrwlx62iu7x3vkn7rhxofgz5&st=tqb1qqqd&dl=0',                                    'pdf_url'  => 'https://www.dropbox.com/scl/fi/9wyp4vz3sx59n18e97qg5/craigzearfoss.pdf?rlkey=sh1gp0x99opsy5hbtl3wpojj3&st=apn7djgj&dl=0',  'public'   => 0 ],
            [ 'name' => 'Front-end Developer [prettified]',         'date' => '2025-07-07', 'primary' => 0, 'doc_url' => 'https://www.dropbox.com/scl/fi/d9oox29eju592bl3n8dnv/craigzearfoss.docx?rlkey=5zo2txdbiwdnf5ke0k9vgci90&st=3b8qs7rh&dl=0',                                    'pdf_url'  => 'https://www.dropbox.com/scl/fi/dk3dc2wrzgo8idx1nr1dh/craigzearfoss.pdf?rlkey=sdu6h9zz5o37sfpfowip431o1&st=vjuux6f3&dl=0',  'public'   => 0 ],
            [ 'name' => 'Front-end Developer [prettified]',         'date' => '2025-07-22', 'primary' => 0, 'doc_url' => 'https://www.dropbox.com/scl/fi/ufli4yrqgm4lxxs04ye9f/craigzearfoss.docx?rlkey=irkim5uy3onev4vqjagk2rqsg&st=dwoslofe&dl=0',                                    'pdf_url'  => 'https://www.dropbox.com/scl/fi/ng4s9j5vtsi8mij8mtii5/craigzearfoss.pdf?rlkey=pfcarlb0c48inmfacmkp4awx6&st=1tizg3mi&dl=0',  'public'   => 0 ],
            [ 'name' => 'Senior Full Stack Developer [prettified]', 'date' => '2025-07-22', 'primary' => 0, 'doc_url' => 'https://www.dropbox.com/scl/fi/ps9dthkbuybfggnszsb4i/craigzearfoss.docx?rlkey=r4fk6ngm8uo43e0e8htc3kxux&st=iz6xdu53&dl=0',                                    'pdf_url'  => 'https://www.dropbox.com/scl/fi/e3oqy77h3xdqhkmyu6j1n/craigzearfoss.pdf?rlkey=pb1uemaaqxsgbm4qlw2bzneds&st=4m5pgd76&dl=0',  'public'   => 0 ],
            [ 'name' => 'Senior PHP Developer [prettified]',        'date' => '2025-07-22', 'primary' => 0, 'doc_url' => 'https://www.dropbox.com/scl/fi/xu90c7e5tqukk9j4b2c80/craigzearfoss.docx?rlkey=t247wae4z5i4a7j4qix68f6pl&st=iv9stw8u&dl=0',                                    'pdf_url'  => 'https://www.dropbox.com/scl/fi/gju304enbljza2335iy74/craigzearfoss.pdf?rlkey=4dgkal9vo2pxazb7af33sbans&st=kk5de6vn&dl=0',  'public'   => 0 ],
            [ 'name' => 'Senior Software Engineer [prettified]',    'date' => '2025-08-07', 'primary' => 1, 'doc_url' => 'https://www.dropbox.com/scl/fi/j7v3olr0dzg35j48p40sn/Craig-Zearfoss_full-stack-developer_20250807.docx?rlkey=b8188h0z70fh7an91wm6jv9nv&st=xearhvb7&dl=0',     'pdf_url'  => null,                                                                                                                       'public'   => 1 ],
            [ 'name' => 'Full Stack Developer [prettified]',        'date' => '2025-08-07', 'primary' => 1, 'doc_url' => 'https://www.dropbox.com/scl/fi/er3u1zc1342ovlcqq56wk/Craig-Zearfoss_senior-software-engineer_20250807.docx?rlkey=yjuhqc9v2l6voemsm0uu4ily2&st=e0ce63v7&dl=0', 'pdf_url'  => null,                                                                                                                       'public'   => 1 ],
            //[ 'name' => '',                                         'date' => null,         'primary' => 0, 'doc_url' => null,                                                                                                                                                          'pdf_url'  => null,                                                                                                                       'public'   => 1 ],
        ];

        if (!empty($data)) {
            Resume::insert($this->additionalColumns($data, true, $this->adminId, ['demo' => $this->demo], boolval($this->demo)));
        }
    }

    /**
     * Adds timestamps, owner_id, and additional fields to each row in a data array.
     *
     * @param array $data
     * @param bool $timestamps
     * @param int|null $ownerId
     * @param array $extraColumns
     * @param bool $addDisclaimer
     * @return array
     */
    protected function additionalColumns(array    $data,
                                         bool     $timestamps = true,
                                         int|null $ownerId = null,
                                         array    $extraColumns = [],
                                         bool     $addDisclaimer = false): array
    {
        for ($i = 0; $i < count($data); $i++) {

            // timestamps
            if ($timestamps) {
                $data[$i]['created_at'] = now();
                $data[$i]['updated_at'] = now();
            }

            // owner_id
            if (!empty($ownerId)) {
                $data[$i]['owner_id'] = $ownerId;
            }

            // extra columns
            foreach ($extraColumns as $name => $value) {
                $data[$i][$name] = $value;
            }

            if ($addDisclaimer) {
                foreach ($extraColumns as $name => $value) {
                    $data[$i]['disclaimer'] = 'This is only for site demo purposes and I do not have any ownership or relationship to it.';
                }
            }
        }

        return $data;
    }
}
