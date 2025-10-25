<?php

namespace App\Console\Commands\CraigZearfoss;

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

class InitCareer extends Command
{
    protected $demo = 0;

    protected $adminId = null;
    protected $groupId = null;
    protected $teamId = null;

    protected $recipeId = [];
    protected $companyId = [];
    protected $contactId = [];

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:init-craig-zearfoss-career {--silent}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will populate the career database with initial data for admin craig-zearfoss';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // get the admin
        if (!$admin = Admin::where('username', 'craig-zearfoss')->first()) {
            echo PHP_EOL . 'Admin `craig-zearfoss` not found.' . PHP_EOL . PHP_EOL;
            die;
        }

        $this->adminId = $admin->id;

        // verify that the admin is a member of an admin team
        if (!$this->teamId = $admin->admin_team_id) {
            echo PHP_EOL . 'Admin `craig-zearfoss` is not on any admin teams.' . PHP_EOL;
            echo 'Please fix before running this script.' . PHP_EOL . PHP_EOL;
            die;
        }

        // verify that the admin belongs to at least one admin group
        if (!$this->groupId = AdminAdminGroup::where('admin_id', $this->adminId)->first()->admin_group_id ?? null) {
            echo PHP_EOL . 'Admin `craig-zearfoss` does not belong to any admin groups.' . PHP_EOL;
            echo 'Please fix before running this script.' . PHP_EOL . PHP_EOL;
            die;
        }

        if (!$this->option('silent')) {
            echo PHP_EOL . 'adminId: ' . $this->adminId . PHP_EOL;
            echo 'teamId: ' . $this->teamId . PHP_EOL;
            echo 'groupId: ' . $this->groupId . PHP_EOL;
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

    protected function addTimeStamps($data) {
        for($i=0; $i<count($data);$i++) {
            $data[$i]['created_at'] = now();
            $data[$i]['updated_at'] = now();
        }

        return $data;
    }

    protected function addDemoTimeStampsAndOwners($data) {
        for($i=0; $i<count($data);$i++) {
            $data[$i]['created_at'] = now();
            $data[$i]['updated_at'] = now();
            $data[$i]['owner_id']   = $this->adminId;
            $data[$i]['demo']       = $this->demo;
        }

        return $data;
    }

    protected function insertCareerApplications(): void
    {
        echo "Inserting into Career\\Application ...\n";

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
            Application::insert($this->addDemoTimeStampsAndOwners($data));
        }
    }

    protected function insertCareerApplicationSkill(): void
    {
        echo "Inserting into Career\\ApplicationSkill ...\n";

        $data = [
        ];

        if (!empty($data)) {
            ApplicationSkill::insert($this->addDemoTimeStampsAndOwners($data));
        }
    }

    protected function insertCareerCompanies(): void
    {
        echo "Inserting into Career\\Commpany ...\n";


        $this->companyId = [];
        $maxId = Company::withoutGlobalScope(AdminGlobalScope::class)->max('id');
        for ($i=1; $i<=84; $i++) {
            $this->companyId[$i] = ++$maxId;
        }

        $data = [
            [ 'id' => $this->companyId[1],   'name' => 'CyberCoders',                      'slug' => 'cybercoders',                     'industry_id' => 11, 'link' => 'https://www.cybercoders.com/',                     'link_name' => null,                       'city' => null,                'state_id'    => 10,   'country_id' => 237  ],
            [ 'id' => $this->companyId[2],   'name' => 'Mondo',                            'slug' => 'mondo',                           'industry_id' => 11, 'link' => 'https://mondo.com/',                               'link_name' => null,                       'city' => null,                'state_id'    => null, 'country_id' => null ],
            [ 'id' => $this->companyId[3],   'name' => 'Randstad',                         'slug' => 'randstad',                        'industry_id' => 11, 'link' => 'https://www.randstadusa.com/',                     'link_name' => null,                       'city' => null,                'state_id'    => 24,   'country_id' => 237  ],
            [ 'id' => $this->companyId[4],   'name' => 'Infinity Consulting Solutions',    'slug' => 'infinity-consulting-solutions',   'industry_id' => 11, 'link' => null,                                               'link_name' => null,                       'city' => null,                'state_id'    => 24,   'country_id' => 237  ],
            [ 'id' => $this->companyId[5],   'name' => 'LinkUp',                           'slug' => 'linkup',                          'industry_id' => 11, 'link' => 'https://www.linkup.com/',                          'link_name' => null,                       'city' => null,                'state_id'    => null, 'country_id' => null ],
            [ 'id' => $this->companyId[6],   'name' => 'Artech',                           'slug' => 'artech',                          'industry_id' => 11, 'link' => 'https://artech.com/',                              'link_name' => null,                       'city' => null,                'state_id'    => null, 'country_id' => null ],
            [ 'id' => $this->companyId[7],   'name' => 'Payzer',                           'slug' => 'payzer',                          'industry_id' => 4,  'link' => 'https://www.wexfsm.com/about/',                    'link_name' => null,                       'city' => null,                'state_id'    => 34,   'country_id' => 237, ],
            [ 'id' => $this->companyId[8],   'name' => 'Horizontal Talent',                'slug' => 'horizontal-talent',               'industry_id' => 11, 'link' => 'https://www.horizontaltalent.com/',                'link_name' => null,                       'city' => null,                'state_id'    => null, 'country_id' => null ],
            [ 'id' => $this->companyId[9],   'name' => 'Robert Half',                      'slug' => 'robert-half',                     'industry_id' => 11, 'link' => 'https://www.roberthalf.com/us/en',                 'link_name' => null,                       'city' => null,                'state_id'    => null, 'country_id' => null ],
            [ 'id' => $this->companyId[10],  'name' => 'BI Worldwide',                     'slug' => 'bi-worldwide',                    'industry_id' => 11, 'link' => 'https://www.biworldwide.com/',                     'link_name' => null,                       'city' => null,                'state_id'    => 24,   'country_id' => 237  ],
            [ 'id' => $this->companyId[11],  'name' => 'Illuminate Education',             'slug' => 'illuminate-education',            'industry_id' => 11, 'link' => 'https://www.illuminateed.com/',                    'link_name' => null,                       'city' => null,                'state_id'    => 24,   'country_id' => 237  ],
            [ 'id' => $this->companyId[12],  'name' => 'Trova',                            'slug' => 'trova',                           'industry_id' => 11, 'link' => 'https://www.trovasearch.com/',                     'link_name' => null,                       'city' => null,                'state_id'    => null, 'country_id' => null ],
            [ 'id' => $this->companyId[13],  'name' => 'Disney Studios',                   'slug' => 'disney-studios',                  'industry_id' => 11, 'link' => 'https://www.disneystudios.com/',                   'link_name' => null,                       'city' => null,                'state_id'    => null, 'country_id' => null ],
            [ 'id' => $this->companyId[14],  'name' => 'Y Scouts',                         'slug' => 'y-scouts',                        'industry_id' => 11, 'link' => 'https://yscouts.com/',                             'link_name' => null,                       'city' => null,                'state_id'    => null, 'country_id' => null ],
            [ 'id' => $this->companyId[15],  'name' => 'TalentFish',                       'slug' => 'talentfish',                      'industry_id' => 11, 'link' => 'https://talentfish.com/',                          'link_name' => null,                       'city' => null,                'state_id'    => null, 'country_id' => null ],
            [ 'id' => $this->companyId[16],  'name' => 'Travelnet Solutions',              'slug' => 'travelnet-solutions',             'industry_id' => 11, 'link' => 'https://tnsinc.com/',                              'link_name' => null,                       'city' => null,                'state_id'    => 24,   'country_id' => 237  ],
            [ 'id' => $this->companyId[17],  'name' => 'University of Minnesota',          'slug' => 'university-of-minnesota',         'industry_id' => 11, 'link' => 'https://twin-cities.umn.edu/',                     'link_name' => null,                       'city' => null,                'state_id'    => 24,   'country_id' => 237  ],
            [ 'id' => $this->companyId[18],  'name' => 'Thomas Arts',                      'slug' => 'thomas-arts',                     'industry_id' => 11, 'link' => 'https://www.thomasarts.com/',                      'link_name' => null,                       'city' => null,                'state_id'    => 24,   'country_id' => 237  ],
            [ 'id' => $this->companyId[19],  'name' => 'Next Ethos Group',                 'slug' => 'next-ethos-group',                'industry_id' => 11, 'link' => 'https://www.linkedin.com/in/steve-zoltan-722649209/', 'link_name' => null,                    'city' => null,                'state_id'    => null, 'country_id' => null ],
            [ 'id' => $this->companyId[20],  'name' => 'CSS Staffing',                     'slug' => 'css-staffing',                    'industry_id' => 11, 'link' => 'https://cssstaffing.com/',                         'link_name' => null,                       'city' => null,                'state_id'    => null, 'country_id' => null ],
            [ 'id' => $this->companyId[21],  'name' => 'Klaviyo',                          'slug' => 'klaviyo',                         'industry_id' => 11, 'link' => 'https://www.klaviyo.com/',                         'link_name' => null,                       'city' => null,                'state_id'    => null, 'country_id' => null ],
            [ 'id' => $this->companyId[22],  'name' => 'LendFlow',                         'slug' => 'lendflow',                        'industry_id' => 11, 'link' => 'https://www.lendflow.com/',                        'link_name' => null,                       'city' => null,                'state_id'    => 44,   'country_id' => 237  ],
            [ 'id' => $this->companyId[23],  'name' => 'Nagios',                           'slug' => 'nagios',                          'industry_id' => 11, 'link' => 'https://www.nagios.org/',                          'link_name' => null,                       'city' => null,                'state_id'    => null, 'country_id' => null ],
            [ 'id' => $this->companyId[24],  'name' => 'Guardian RFID',                    'slug' => 'guardian-rfid',                   'industry_id' => 11, 'link' => 'https://guardianrfid.com/',                        'link_name' => null,                       'city' => null,                'state_id'    => null, 'country_id' => null ],
            [ 'id' => $this->companyId[25],  'name' => 'Burnout Brands',                   'slug' => 'burnout-brands',                  'industry_id' => 11, 'link' => 'https://www.linkedin.com/company/burnout-brands/', 'link_name' => null,                       'city' => null,                'state_id'    => null, 'country_id' => null ],
            [ 'id' => $this->companyId[26],  'name' => 'Quility Insurance Holdings LLC',   'slug' => 'quility-insurance-holdings-llc',  'industry_id' => 11, 'link' => 'https://quility.com/',                             'link_name' => null,                       'city' => null,                'state_id'    => null, 'country_id' => null ],
            [ 'id' => $this->companyId[27],  'name' => 'Divelement Web Services, LLC',     'slug' => 'divelement-web-services-llc',     'industry_id' => 11, 'link' => 'https://divelement.io/',                           'link_name' => null,                       'city' => null,                'state_id'    => null, 'country_id' => null ],
            [ 'id' => $this->companyId[28],  'name' => 'Givelify',                         'slug' => 'giverlify',                       'industry_id' => 11, 'link' => 'https://www.givelify.com/',                        'link_name' => null,                       'city' => null,                'state_id'    => null, 'country_id' => null ],
            [ 'id' => $this->companyId[29],  'name' => 'Ingenious',                        'slug' => 'Ingenious',                       'industry_id' => 10, 'link' => 'https://ingenious.agency/',                        'link_name' => null,                       'city' => null,                'state_id'    => 6,    'country_id' => 237  ],
            [ 'id' => $this->companyId[30],  'name' => 'Advocates for Human Potential, Inc.', 'slug' => 'advocates-for-human-potential-inc', 'industry_id' => 11, 'link' => 'https://ahpnet.com/',                         'link_name' => null,                       'city' => null,                'state_id'    => 22,   'country_id' => 237  ],
            [ 'id' => $this->companyId[31],  'name' => 'Qualibar Inc',                     'slug' => 'qualibar-inc',                    'industry_id' => 11, 'link' => 'https://qualibar.com/',                            'link_name' => null,                       'city' => null,                'state_id'    => 11,   'country_id' => 237  ],
            [ 'id' => $this->companyId[32],  'name' => 'MembersFirst',                     'slug' => 'membersfirst',                    'industry_id' => 11, 'link' => 'https://www.membersfirst.com/',                    'link_name' => null,                       'city' => null,                'state_id'    => 22,   'country_id' => 237  ],
            [ 'id' => $this->companyId[33],  'name' => 'Vultr',                            'slug' => 'vultr',                           'industry_id' => 11, 'link' => 'https://www.vultr.com/',                           'link_name' => null,                       'city' => null,                'state_id'    => null, 'country_id' => null ],
            [ 'id' => $this->companyId[34],  'name' => 'Inseego',                          'slug' => 'inseego',                         'industry_id' => 11, 'link' => 'https://inseego.com/',                             'link_name' => null,                       'city' => null,                'state_id'    => null, 'country_id' => null ],
            [ 'id' => $this->companyId[35],  'name' => 'iClassPro, Inc',                   'slug' => 'iclasspro-inc',                   'industry_id' => 11, 'link' => 'https://www.iclasspro.com/',                       'link_name' => null,                       'city' => null,                'state_id'    => 44,   'country_id' => 237  ],
            [ 'id' => $this->companyId[36],  'name' => 'Avolution',                        'slug' => 'avolution',                       'industry_id' => 11, 'link' => 'https://www.avolutionsoftware.com/',               'link_name' => null,                       'city' => null,                'state_id'    => null, 'country_id' => null ],
            [ 'id' => $this->companyId[37],  'name' => 'McGraw Hill',                      'slug' => 'McGraw Hill',                     'industry_id' => 11, 'link' => 'https://www.mheducation.com/',                     'link_name' => null,                       'city' => null,                'state_id'    => null, 'country_id' => null ],
            [ 'id' => $this->companyId[38],  'name' => 'Sumas Edge Corporation',           'slug' => 'sumas-edge-corporation',          'industry_id' => 11, 'link' => 'https://sumasedge.com/',                           'link_name' => null,                       'city' => null,                'state_id'    => 31,   'country_id' => 237  ],
            [ 'id' => $this->companyId[39],  'name' => 'Airbnb',                           'slug' => 'aifbnb',                          'industry_id' => 11, 'link' => 'https://www.airbnb.com/',                          'link_name' => null,                       'city' => null,                'state_id'    => null, 'country_id' => 237  ],
            [ 'id' => $this->companyId[40],  'name' => 'Wikimedia Foundation',             'slug' => 'wikimedia-foundation',            'industry_id' => 11, 'link' => 'https://wikimediafoundation.org/',                 'link_name' => null,                       'city' => null,                'state_id'    => null, 'country_id' => null ],
            [ 'id' => $this->companyId[41],  'name' => 'Harbor Compliance',                'slug' => 'harbor-compliance',               'industry_id' => 11, 'link' => 'https://www.harborcompliance.com/',                'link_name' => null,                       'city' => null,                'state_id'    => null, 'country_id' => null ],
            [ 'id' => $this->companyId[42],  'name' => 'Agital',                           'slug' => 'agital',                          'industry_id' => 11, 'link' => 'https://gofishdigital.com/services/social-commerce/live-shopping/', 'link_name' => null,      'city' => null,                'state_id'    => null, 'country_id' => null ],
            [ 'id' => $this->companyId[43],  'name' => 'Sharp Source IT',                  'slug' => 'sharp-source-it',                 'industry_id' => 11, 'link' => 'https://sharpsourceit.com/',                       'link_name' => null,                       'city' => null,                'state_id'    => 11,   'country_id' => 237  ],
            [ 'id' => $this->companyId[44],  'name' => 'SPECTRAFORCE Technologies Inc',    'slug' => 'spectraforce-technologies-inc',   'industry_id' => 11, 'link' => 'https://spectraforce.com/',                        'link_name' => null,                       'city' => null,                'state_id'    => null, 'country_id' => null ],
            [ 'id' => $this->companyId[45],  'name' => 'Ovia Health',                      'slug' => 'ovia-health',                     'industry_id' => 11, 'link' => 'https://www.oviahealth.com/',                      'link_name' => null,                       'city' => null,                'state_id'    => null, 'country_id' => null ],
            [ 'id' => $this->companyId[46],  'name' => 'JOBS by allUP',                    'slug' => 'jobs-by-allup',                   'industry_id' => 11, 'link' => 'https://www.allup.world/',                         'link_name'   => 'LinkedIn website',       'city' => null,                'state_id'    => null, 'country_id' => 237  ],
            [ 'id' => $this->companyId[47],  'name' => 'iostudio',                         'slug' => 'iostudio',                        'industry_id' => 29, 'link' => 'https://iostudio.com/',                            'link_name'   => 'iostudio website',       'city' => null,                'state_id'    => null, 'country_id' => 237  ],
            [ 'id' => $this->companyId[48],  'name' => 'Black Airplane',                   'slug' => 'black-airplane',                  'industry_id' => 11, 'link' => 'https://blackairplane.com/',                       'link_name'   => 'Black Airplane website', 'city' => null,                'state_id'    => null, 'country_id' => 237  ],
            [ 'id' => $this->companyId[49],  'name' => 'Pacifica Media',                   'slug' => 'pacifica-media',                  'industry_id' => 11, 'link' => 'https://pacificamedia.com/',                       'link_name'   => null,                     'city' => null,                'state_id'    => null, 'country_id' => 237  ],
            [ 'id' => $this->companyId[50],  'name' => 'Parsetek Inc',                     'slug' => 'parsetek-inc',                    'industry_id' => 11, 'link' => 'http://www.parsetek.com/',                         'link_name'   => null,                     'city' => 'Chantilly',         'state_id'    => 47,   'country_id' => 237  ],
            [ 'id' => $this->companyId[51],  'name' => 'Pixels.com',                       'slug' => 'pixels-com',                      'industry_id' => 11, 'link' => 'https://pixels.com/',                              'link_name'   => null,                     'city' => 'Santa Monica',      'state_id'    => 5,    'country_id' => 237  ],
            [ 'id' => $this->companyId[52],  'name' => 'Premier Staffing Partners',        'slug' => 'premier-staffing-partners',       'industry_id' => 11, 'link' => 'https://www.premierstaffingpartners.com/',         'link_name'   => null,                     'city' => 'Knoxville',         'state_id'    => 43,   'country_id' => 237  ],
            [ 'id' => $this->companyId[53],  'name' => 'Printful',                         'slug' => 'printful',                        'industry_id' => 11, 'link' => 'https://www.printful.com/',                        'link_name'   => null,                     'city' => null,                'state_id'    => null, 'country_id' => 237  ],
            [ 'id' => $this->companyId[54],  'name' => 'Reliable Software Resources Inc',  'slug' => 'reliable-software-resources-inc', 'industry_id' => 11, 'link' => 'https://www.rsrit.com/',                           'link_name'   => null,                     'city' => 'Bridgewater',       'state_id'    => 31,   'country_id' => 237  ],
            [ 'id' => $this->companyId[55],  'name' => 'Ringside Talent',                  'slug' => 'ringside-talent',                 'industry_id' => 11, 'link' => 'https://ringsidetalent.com/',                      'link_name'   => null,                     'city' => 'Columbus',          'state_id'    => 36,   'country_id' => 237  ],
            [ 'id' => $this->companyId[56],  'name' => 'RIT Solutions',                    'slug' => 'rit-solutions',                   'industry_id' => 11, 'link' => 'https://ritsolinc.jobs.net/',                      'link_name'   => null,                     'city' => 'Washington',        'state_id'    => 9,    'country_id' => 237  ],
            [ 'id' => $this->companyId[57],  'name' => 'RowsOne',                          'slug' => 'rowsone',                         'industry_id' => 11, 'link' => 'https://www.rowshr.com/',                          'link_name'   => null,                     'city' => null,                'state_id'    => null, 'country_id' => 237  ],
            [ 'id' => $this->companyId[58],  'name' => 'Search Solutions, LLC',            'slug' => 'search-solutions-llc',            'industry_id' => 11, 'link' => 'https://www.thesearchsolutions.com/',              'link_name'   => null,                     'city' => 'Thousand Oaks',     'state_id'    => 5,    'country_id' => 237  ],
            [ 'id' => $this->companyId[59],  'name' => 'ServiceNow',                       'slug' => 'servicenow',                      'industry_id' => 11, 'link' => 'https://www.servicenow.com/',                      'link_name'   => null,                     'city' => null,                'state_id'    => null, 'country_id' => 237  ],
            [ 'id' => $this->companyId[60],  'name' => 'SolidProfessor',                   'slug' => 'solidprofessor',                  'industry_id' => 11, 'link' => 'https://solidprofessor.com/',                      'link_name'   => null,                     'city' => null,                'state_id'    => null, 'country_id' => 237  ],
            [ 'id' => $this->companyId[61],  'name' => 'Sun West Mortgage',                'slug' => 'sun-west-mortgage',               'industry_id' => 11, 'link' => 'https://www.swmc.com/',                            'link_name'   => null,                     'city' => null,                'state_id'    => null, 'country_id' => 237  ],
            [ 'id' => $this->companyId[62],  'name' => 'Symplicity Corporation',           'slug' => 'symplicity-corporation',          'industry_id' => 11, 'link' => 'https://www.symplicity.com/',                      'link_name'   => null,                     'city' => null,                'state_id'    => null, 'country_id' => 237  ],
            [ 'id' => $this->companyId[63],  'name' => 'Think Agency, Inc',                'slug' => 'think-agency-inc',                'industry_id' => 11, 'link' => 'https://thinkagency.com/',                         'link_name'   => null,                     'city' => 'Altamonte Springs', 'state_id'    => 10,   'country_id' => 237  ],
            [ 'id' => $this->companyId[64],  'name' => 'Total Expert',                     'slug' => 'total-expert',                    'industry_id' => 11, 'link' => 'https://www.totalexpert.com/',                     'link_name'   => null,                     'city' => 'St. Louis Park',    'state_id'    => 24,   'country_id' => 237  ],
            [ 'id' => $this->companyId[65],  'name' => 'Tukios',                           'slug' => 'tukios',                          'industry_id' => 11, 'link' => 'https://www.tukios.com/',                          'link_name'   => null,                     'city' => 'Ogden',             'state_id'    => 45,   'country_id' => 237  ],
            [ 'id' => $this->companyId[66],  'name' => 'Usked LLC',                        'slug' => 'usked LLC',                       'industry_id' => 11, 'link' => 'http://usked.com/',                                'link_name'   => null,                     'city' => 'Washington',        'state_id'    => 9,    'country_id' => 237  ],
            [ 'id' => $this->companyId[67],  'name' => 'ValoreMVP',                        'slug' => 'valoremvp',                       'industry_id' => 11, 'link' => 'https://valoremvp.com/',                           'link_name'   => null,                     'city' => null,                'state_id'    => null, 'country_id' => 237  ],
            [ 'id' => $this->companyId[68],  'name' => 'Vanta',                            'slug' => 'vanta',                           'industry_id' => 11, 'link' => 'https://www.vanta.com/',                           'link_name'   => null,                     'city' => null,                'state_id'    => null, 'country_id' => 237  ],
            [ 'id' => $this->companyId[69],  'name' => 'Velocity Tech Inc',                'slug' => 'velocity-tech-inc',               'industry_id' => 11, 'link' => 'https://velocitytechinc.com/',                     'link_name'   => null,                     'city' => 'Bedford',           'state_id'    => 44,   'country_id' => 237  ],
            [ 'id' => $this->companyId[70],  'name' => 'Veracity Software Inc',            'slug' => 'veracity-software-inc',           'industry_id' => 11, 'link' => 'https://veracity-us.com/',                         'link_name'   => null,                     'city' => null,                'state_id'    => null, 'country_id' => 237  ],
            [ 'id' => $this->companyId[71],  'name' => 'Vernovis',                         'slug' => 'vernovis',                        'industry_id' => 11, 'link' => 'https://vernovis.com/',                            'link_name'   => null,                     'city' => 'Mason',             'state_id'    => 36,   'country_id' => 237  ],
            [ 'id' => $this->companyId[72],  'name' => 'VetsEZ',                           'slug' => 'vetsez',                          'industry_id' => 11, 'link' => 'https://vetsez.com/',                              'link_name'   => null,                     'city' => null,                'state_id'    => null, 'country_id' => 237  ],
            [ 'id' => $this->companyId[73],  'name' => 'Victory',                          'slug' => 'victory',                         'industry_id' => 11, 'link' => 'https://victorycto.com/',                          'link_name'   => null,                     'city' => null,                'state_id'    => null, 'country_id' => 237  ],
            [ 'id' => $this->companyId[74],  'name' => 'Vozzi',                            'slug' => 'vozzi',                           'industry_id' => 11, 'link' => 'https://site.getvozzi.com/',                       'link_name'   => null,                     'city' => 'Salt Lake City',    'state_id'    => 45,   'country_id' => 237  ],
            [ 'id' => $this->companyId[75],  'name' => 'Web Connectivity LLC',             'slug' => 'web-connectivity-llc',            'industry_id' => 11, 'link' => 'https://www.webconnectivity.com/',                 'link_name'   => null,                     'city' => 'Indianapolis',      'state_id'    => 15,   'country_id' => 237  ],
            [ 'id' => $this->companyId[76],  'name' => 'WebOrigo',                         'slug' => 'webOrigo',                        'industry_id' => 11, 'link' => 'https://weborigo.com/',                            'link_name'   => null,                     'city' => null,                'state_id'    => null, 'country_id' => null ],
            [ 'id' => $this->companyId[77],  'name' => 'Zywave',                           'slug' => 'zywave',                          'industry_id' => 11, 'link' => 'https://www.zywave.com/',                          'link_name'   => null,                     'city' => 'Milwaukee',         'state_id'    => 50,   'country_id' => 237  ],
            [ 'id' => $this->companyId[78],  'name' => 'Lumion',                           'slug' => 'lumion',                          'industry_id' => 11, 'link' => 'https://lumion.com/',                              'link_name'   => null,                     'city' => null,                'state_id'    => null, 'country_id' => 237  ],
            [ 'id' => $this->companyId[79],  'name' => 'Regal Cloud',                      'slug' => 'regal-cloud',                     'industry_id' => 11, 'link' => 'https://www.regal-cloud.com/',                     'link_name'   => null,                     'city' => 'Austin',            'state_id'    => 44,   'country_id' => 237  ],
            [ 'id' => $this->companyId[80],  'name' => 'Tyler Technologies, Inc',          'slug' => 'tyler-technologies-inc',          'industry_id' => 11, 'link' => 'https://www.tylertech.com/',                       'link_name'   => null,                     'city' => 'Plano',             'state_id'    => 44,   'country_id' => 237  ],
            [ 'id' => $this->companyId[81],  'name' => 'IntertiaJS',                       'slug' => 'intertiajs',                      'industry_id' => 11, 'link' => 'https://inertiajs.com/',                           'link_name'   => null,                     'city' => null,                'state_id'    => null, 'country_id' => 237  ],
            [ 'id' => $this->companyId[82],  'name' => 'Crossing Hurdles',                 'slug' => 'crossing-hurdles',                'industry_id' => 11, 'link' => 'https://www.linkedin.com/company/crossinghurdles/','link_name'   => null,                     'city' => null,                'state_id'    => null, 'country_id' => 237  ],
            [ 'id' => $this->companyId[83],  'name' => 'USALCO',                           'slug' => 'usalco',                          'industry_id' => 11, 'link' => 'https://www.usalco.com/',                          'link_name'   => null,                     'city' => 'Baltimore',         'state_id'    => 21,   'country_id' => 237  ],
            [ 'id' => $this->companyId[84],  'name' => 'Idaho National Laboratory',        'slug' => 'idaho-national-laboratory',       'industry_id' => 11, 'link' => 'https://inl.gov/',                                 'link_name'   => null,                     'city' => 'Idaho Falls',       'state_id'    => 13,   'country_id' => 237  ],
            //[ 'id' => 1,   'name' => '',                                 'slug' => '',                                'industry_id' => 11, 'link' => null,                                               'link_name'   => null,                     'city' => null,                'state_id'    => null, 'country_id' => null ],
        ];

        if (!empty($data)) {
            Company::insert($this->addDemoTimeStampsAndOwners($data));
        }
    }

    protected function insertCareerCompanyContacts(): void
    {
        echo "Inserting into Career\\CommpanyContact ...\n";

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
            CompanyContact::insert($this->addTimeStamps($data));
        }
    }

    protected function insertCareerContacts(): void
    {
        echo "Inserting into Career\\Contact ...\n";

        $this->contactId = [];
        $maxId = Contact::withoutGlobalScope(AdminGlobalScope::class)->max('id');
        for ($i=1; $i<=23; $i++) {
            $this->contactId[$i] = ++$maxId;
        }

        $data = [
            [ 'id' => $this->contactId[1],   'name' => 'Chad Vasquez',     'slug' => 'chad-vasquez',     'phone' => null,	            'phone_label' => null,   'email' => 'Chad.Vasquez@CyberCoders.com',         'email_label' => 'work' ],
            [ 'id' => $this->contactId[2],   'name' => 'Lyman Ambrose',    'slug' => 'lyman-ambrose',    'phone' => null,	            'phone_label' => null,   'email' => 'lyman.ambrose@mondo.com',              'email_label' => 'work' ],
            [ 'id' => $this->contactId[3],   'name' => 'Miles Biegert',    'slug' => 'miles-biegert',    'phone' => null,               'phone_label' => null,   'email' => 'milesb@infinity-cs.com',               'email_label' => 'work' ],
            [ 'id' => $this->contactId[4],   'name' => 'Jolly Nibu',       'slug' => 'jolly-nibu',       'phone' => null,	            'phone_label' => null,   'email' => 'jolly.nibu@artech.com',                'email_label' => 'work' ],
            [ 'id' => $this->contactId[5],   'name' => 'Connor Sullivan',  'slug' => 'connor-sullivan',  'phone' => null,	            'phone_label' => null,   'email' => null,                                   'email_label' => null   ],
            [ 'id' => $this->contactId[6],   'name' => 'Jordan Luehmann',  'slug' => 'jordan-luehmann',  'phone' => null,	            'phone_label' => null,   'email' => 'jluehmann@horizontal.com',             'email_label' => 'work' ],
            [ 'id' => $this->contactId[7],   'name' => 'Steve Allen',      'slug' => 'steve-allen',      'phone' => null,	            'phone_label' => null,   'email' => null,                                   'email_label' => null   ],
            [ 'id' => $this->contactId[8],   'name' => 'Victor Fung',      'slug' => 'victor-fung',      'phone' => null,               'phone_label' => null,   'email' => null,                                   'email_label' => null   ],
            [ 'id' => $this->contactId[9],   'name' => 'Jessica Chandler', 'slug' => 'jessica-chandler', 'phone' => null,               'phone_label' => null,   'email' => null,                                   'email_label' => null   ],
            [ 'id' => $this->contactId[10],  'name' => 'Donna Morgan',     'slug' => 'donna-morgan',     'phone' => null,               'phone_label' => null,   'email' => null,                                   'email_label' => null   ],
            [ 'id' => $this->contactId[11],  'name' => 'Kirsten Carlson',  'slug' => 'kirsten-carlson',  'phone' => null,	            'phone_label' => null,   'email' => null,                                   'email_label' => null   ],
            [ 'id' => $this->contactId[12],  'name' => 'Kyle Nussberger',  'slug' => 'kyle-nussberger',  'phone' => null,	            'phone_label' => null,   'email' => null,                                   'email_label' => null   ],
            [ 'id' => $this->contactId[13],  'name' => 'Andrew Jones',     'slug' => 'andrew-jones',     'phone' => null,	            'phone_label' => null,   'email' => null,                                   'email_label' => null   ],
            [ 'id' => $this->contactId[14],  'name' => 'Dylan Rogelstad',  'slug' => 'dylan-rogelstad',  'phone' => null,	            'phone_label' => null,   'email' => 'dylan.rogelstad@mail.cybercoders.com', 'email_label' => 'work' ],
            [ 'id' => $this->contactId[15],  'name' => 'Larry Kraynak',    'slug' => 'larry-kraynak',    'phone' => null,	            'phone_label' => null,   'email' => null,                                   'email_label' => null   ],
            [ 'id' => $this->contactId[16],  'name' => 'Tim Lesnick',      'slug' => 'tim-lesnick',      'phone' => null,               'phone_label' => null,   'email' => 'tlesnick@trovasearch.com',             'email_label' => 'work' ],
            [ 'id' => $this->contactId[17],  'name' => 'Ciara Monahan',    'slug' => 'ciara-monahan',    'phone' => null,               'phone_label' => null,   'email' => 'Ciara.Monahan@insightglobal.com',      'email_label' => 'work' ],
            [ 'id' => $this->contactId[18],  'name' => 'Rob Neylon',       'slug' => 'rob-neylon',       'phone' => null,	            'phone_label' => null,   'email' => 'rob@yscouts.com',                      'email_label' => 'work' ],
            [ 'id' => $this->contactId[19],  'name' => 'Billy Bisson',     'slug' => 'billy-bisson',     'phone' => null,	            'phone_label' => null,   'email' => null,                                   'email_label' => null   ],
            [ 'id' => $this->contactId[20],  'name' => 'Kelsey Higgins',   'slug' => 'kelsey-higgins',   'phone' => '(774) 283-1614',   'phone_label' => 'work', 'email' => 'kelsey.higgins@klaviyo.com',           'email_label' => 'work' ],
            [ 'id' => $this->contactId[21],  'name' => 'Britney Coleman',  'slug' => 'britney-coleman',  'phone' => null,	            'phone_label' => null,   'email' => 'coleman@lendflow.io',                  'email_label' => 'work' ],
            [ 'id' => $this->contactId[22],  'name' => 'Dan Chaffee',      'slug' => 'dan-chaffee',      'phone' => null,	            'phone_label' => null,   'email' => null,                                   'email_label' => null   ],
            [ 'id' => $this->contactId[23],  'name' => 'Kara Caldwell',    'slug' => 'kara-caldwell',    'phone' => null,	            'phone_label' => null,   'email' => null,                                   'email_label' => null   ],
            //[ 'id' => 1,   'name' => '',                 'slug' => '',                 'phone' => null,	            'phone_label' => null,   'email' => null,                                   'email_label' => null   ],
        ];

        if (!empty($data)) {
            Contact::insert($this->addDemoTimeStampsAndOwners($data));
        }
    }

    protected function insertCareerCommunications(): void
    {
        echo "Inserting into Career\\Communication ...\n";

        $data = [
        ];

        if (!empty($data)) {
            Communication::insert($this->addDemoTimeStampsAndOwners($data));
        }
    }

    protected function insertCareerCoverLetters(): void
    {
        echo "Inserting into Career\\CoverLetter ...\n";

        $data = [
        ];

        if (!empty($data)) {
            CoverLetter::insert($this->addDemoTimeStampsAndOwners($data));
        }
    }

    protected function insertCareerEvents(): void
    {
        echo "Inserting into Career\\Event ...\n";

        $data = [
        ];

        if (!empty($data)) {
            Event::insert($this->addDemoTimeStampsAndOwners($data));
        }
    }

    protected function insertCareerNotes(): void
    {
        echo "Inserting into Career\\Note ...\n";

        $data = [
        ];

        if (!empty($data)) {
            Note::insert($this->addDemoTimeStampsAndOwners($data));
        }
    }

    protected function insertCareerReferences(): void
    {
        echo "Inserting into Career\\Reference ...\n";

        $data = [
            [ 'name' => 'Kevin Hemsley',         'slug' => 'kevin-hemsley',         'friend' => 0, 'family' => 0, 'coworker' => 0, 'supervisor' => 1, 'subordinate' => 0, 'professional' => 0, 'other' => 0, 'company_id' => 85,   'street' => null,                      'street2' => null,  'city' => 'Rigby',         'state_id' => 13,   'zip' => null,         'country_id' => 237, 'phone' => '(208) 526-0507', 'phone_label' => 'work',   'alt_phone' => '(208) 317-3644', 'alt_phone_label' => 'mobile', 'email' => 'kevin.hemsley@inl.gov',          'email_label' => 'work', 'alt_email' => null,                  'alt_email_label' => null,    'birthday' => null,         'link' => 'https://www.linkedin.com/in/kevin-hemsley-a30740132/' ],
            [ 'name' => 'Paul Davis',            'slug' => 'paul-davis',            'friend' => 0, 'family' => 0, 'coworker' => 0, 'supervisor' => 1, 'subordinate' => 0, 'professional' => 0, 'other' => 0, 'company_id' => 85,   'street' => null,                      'street2' => null,  'city' => null,            'state_id' => null, 'zip' => null,         'country_id' => 237, 'phone' => '(913) 608-5399', 'phone_label' => null,     'alt_phone' => null,             'alt_phone_label' => null,     'email' => 'paul.davis@inl.gov',             'email_label' => 'work', 'alt_email' => 'prtdavis2@yahoo.com', 'alt_email_label' => 'home',  'birthday' => null,         'link' => null ],
            [ 'name' => 'Alen Kahen',            'slug' => 'alen-kahen',            'friend' => 0, 'family' => 0, 'coworker' => 1, 'supervisor' => 0, 'subordinate' => 0, 'professional' => 0, 'other' => 0, 'company_id' => 85,   'street' => null,                      'street2' => null,  'city' => null,            'state_id' => 33,   'zip' => null,         'country_id' => 237, 'phone' => '(917) 685-6003', 'phone_label' => 'home',   'alt_phone' => null,             'alt_phone_label' => null,     'email' => 'akahen@live.com',                'email_label' => 'home', 'alt_email' => 'alen.kahen@inl.com',  'alt_email_label' => 'work',  'birthday' => null,         'link' => null ],
            [ 'name' => 'Nancy Gomez Dominguez', 'slug' => 'nancy-gomez-dominguez', 'friend' => 0, 'family' => 0, 'coworker' => 1, 'supervisor' => 0, 'subordinate' => 0, 'professional' => 0, 'other' => 0, 'company_id' => 85,   'street' => null,                      'street2' => null,  'city' => null,            'state_id' => null, 'zip' => null,         'country_id' => 237, 'phone' => '(603) 779-2707', 'phone_label' => 'mobile', 'alt_phone' => '(208) 526-4280', 'alt_phone_label' => 'work',   'email' => 'nancy.gomezdominguez@inl.gov',   'email_label' => 'work', 'alt_email' => 'ngd.00@outlook.com',  'alt_email_label' => 'home',  'birthday' => null,         'link' => null ],
            [ 'name' => 'Barbara Zearfoss',      'slug' => 'barbara-zearfoss',      'friend' => 0, 'family' => 1, 'coworker' => 0, 'supervisor' => 0, 'subordinate' => 0, 'professional' => 0, 'other' => 0, 'company_id' => null, 'street' => '2678 Sunset Lane',        'street2' => null,  'city' => 'York',          'state_id' => 39,   'zip' => '17408-9567', 'country_id' => 237, 'phone' => '(717) 764-1215', 'phone_label' => 'home',   'alt_phone' => '(717) 891-1207', 'alt_phone_label' => 'mobile', 'email' => 'BZearfoss@aol.com',              'email_label' => 'home', 'alt_email' => null,                  'alt_email_label' => null,    'birthday' => '1942-08-20', 'link' => null ],
            [ 'name' => 'Mark Zearfoss',         'slug' => 'mark-zearfoss',         'friend' => 0, 'family' => 1, 'coworker' => 0, 'supervisor' => 0, 'subordinate' => 0, 'professional' => 0, 'other' => 0, 'company_id' => null, 'street' => '380 Richardson Rd.',      'street2' => null,  'city' => 'York',          'state_id' => 39,   'zip' => '17404',      'country_id' => 237, 'phone' => '(717) 792-7795', 'phone_label' => 'home',   'alt_phone' => '(717) 332-1415', 'alt_phone_label' => 'mobile', 'email' => 'zearfoss@verizon.net',           'email_label' => 'home', 'alt_email' => null,                  'alt_email_label' => null,    'birthday' => '1962-07-19', 'link' => null ],
            [ 'name' => 'Doug Zearfoss',         'slug' => 'doug-zearfoss',         'friend' => 0, 'family' => 1, 'coworker' => 0, 'supervisor' => 0, 'subordinate' => 0, 'professional' => 0, 'other' => 0, 'company_id' => null, 'street' => '9652 Rolling Rock Way',   'street2' => null,  'city' => 'Reno',          'state_id' => 29,   'zip' => '89521',      'country_id' => 237, 'phone' => '(775) 852-1264', 'phone_label' => 'home',   'alt_phone' => '(775) 762-0775', 'alt_phone_label' => 'mobile', 'email' => 'DZearfoss@aol.com',              'email_label' => 'home', 'alt_email' => 'dzearfoss@eigwc.com', 'alt_email_label' => 'work',  'birthday' => '1965-11-25', 'link' => null ],
            [ 'name' => 'Gary Zearfoss',         'slug' => 'gary-zearfoss',         'friend' => 0, 'family' => 1, 'coworker' => 0, 'supervisor' => 0, 'subordinate' => 0, 'professional' => 0, 'other' => 0, 'company_id' => null, 'street' => '2678 Sunset Lane',        'street2' => null,  'city' => 'York',          'state_id' => 39,   'zip' => '17408-9567', 'country_id' => 237, 'phone' => '(717) 764-1215', 'phone_label' => 'home',   'alt_phone' => null,             'alt_phone_label' => null,     'email' => null,                             'email_label' => null,   'alt_email' => null,                  'alt_email_label' => null,    'birthday' => '1941-09-11', 'link' => null ],
            [ 'name' => 'Maria Arvanitis',       'slug' => 'maria-arvanitis',       'friend' => 1, 'family' => 0, 'coworker' => 0, 'supervisor' => 0, 'subordinate' => 0, 'professional' => 0, 'other' => 0, 'company_id' => null, 'street' => '9079 Golden Pond Lane N', 'street2' => null,  'city' => 'Monticello',    'state_id' => 24,   'zip' => '55362',      'country_id' => 237, 'phone' => '(763) 777-2216', 'phone_label' => 'mobile', 'alt_phone' => null,             'alt_phone_label' => null,     'email' => 'mariaelaine29@yahoo.com',        'email_label' => 'home', 'alt_email' => null,                  'alt_email_label' => null,    'birthday' => '1980-07-30', 'link' => null ],
            [ 'name' => 'Barbara Smith',         'slug' => 'barbara-smith',         'friend' => 1, 'family' => 0, 'coworker' => 0, 'supervisor' => 0, 'subordinate' => 0, 'professional' => 0, 'other' => 0, 'company_id' => null, 'street' => '2041 Warwick Place',      'street2' => null,  'city' => 'New Braunfels', 'state_id' => 44,   'zip' => '78130',      'country_id' => 237, 'phone' => '(830) 221-8713', 'phone_label' => 'home',   'alt_phone' => null,             'alt_phone_label' => null,     'email' => 'refugeechildrendream@yahoo.com', 'email_label' => 'home', 'alt_email' => null,                  'alt_email_label' => null,    'birthday'  => null,        'link' => null ],
        ];

        if (!empty($data)) {
            Reference::insert($this->addDemoTimeStampsAndOwners($data));
        }
    }

    protected function insertCareerResumes(): void
    {
        echo "Inserting into Career\\Resume ...\n";

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
            Resume::insert($this->addDemoTimeStampsAndOwners($data));
        }
    }
}
