<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * @var string
     */
    protected string $database_tag = 'career_db';

    /**
     * @var string
     */
    protected string $table_name = 'job_boards';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection($this->database_tag)->create($this->table_name, function (Blueprint $table) {

            $systemDbName = Schema::connection('system_db')->getCurrentSchemaName();

            $table->id();
            $table->string('name', 100)->unique('name_unique');
            $table->string('slug', 100)->unique('slug_unique');
            $table->boolean('primary')->default(false);
            $table->string('summary', 500)->nullable();
            $table->boolean('local')->default(false);
            $table->boolean('regional')->default(false);
            $table->boolean('national')->default(false);
            $table->boolean('international')->default(false);
            $table->string('street')->nullable();
            $table->string('street2')->nullable();
            $table->string('city', 100)->nullable()->index('city_idx');
            $table->foreignId('state_id')
                ->nullable()
                ->constrained($systemDbName.'.states', 'id')
                ->onDelete('cascade');
            $table->string('zip', 20)->nullable();
            $table->foreignId('country_id')
                ->nullable()
                ->constrained($systemDbName.'.countries', 'id')
                ->onDelete('cascade');
            $table->float('latitude')->nullable();
            $table->float('longitude')->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('phone_label', 100)->nullable();
            $table->string('alt_phone', 20)->nullable();
            $table->string('alt_phone_label', 100)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('email_label', 100)->nullable();
            $table->string('alt_email', 255)->nullable();
            $table->string('alt_email_label', 100)->nullable();
            $table->text('notes')->nullable();
            $table->string('link', 500)->nullable();
            $table->string('link_name')->nullable();
            $table->text('description')->nullable();
            $table->string('image', 500)->nullable();
            $table->string('image_credit')->nullable();
            $table->string('image_source')->nullable();
            $table->string('thumbnail', 500)->nullable();
            $table->boolean('is_public')->default(true);
            $table->boolean('is_readonly')->default(false);
            $table->boolean('is_root')->default(false);
            $table->boolean('is_disabled')->default(false);
            $table->boolean('is_demo')->default(false);
            $table->integer('sequence')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        $data = [
            [ 'id' => 1,  'name' => 'other',              'slug' => 'other',              'primary' => 1,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 0, 'link' => null,                                             'summary' => null ],
            [ 'id' => 2,  'name' => 'Dice',               'slug' => 'dice',               'primary' => 1,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 1, 'link' => 'https://dice.com/',                              'summary' => 'An industry-specific job site serving the technology and IT fields.' ],
            [ 'id' => 3,  'name' => 'Indeed',             'slug' => 'indeed',             'primary' => 1,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 1, 'link' => 'https://indeed.com/',                            'summary' => 'One of the world\’s largest job boards.' ],
            [ 'id' => 4,  'name' => 'iHireTechnology',    'slug' => 'ihiretechnology',    'primary' => 1,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 1, 'link' => 'https://ihiretechnology.com/',                   'summary' => null ],
            [ 'id' => 5,  'name' => 'JobLeads',           'slug' => 'jobleads',           'primary' => 1,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 1, 'link' => 'https://jobleads.com/',                          'summary' => null ],
            [ 'id' => 6,  'name' => 'Jobright',           'slug' => 'jobright',           'primary' => 1,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 1, 'link' => 'https://jobright.ai/',                           'summary' => null ],
            [ 'id' => 7,  'name' => 'LaraJobs',           'slug' => 'larajobs',           'primary' => 1,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 1, 'link' => 'https://larajobs.com/',                          'summary' => null ],
            [ 'id' => 8,  'name' => 'Lensa',              'slug' => 'lensa',              'primary' => 1,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 1, 'link' => 'https://lensa.com/',                             'summary' => null ],
            [ 'id' => 9,  'name' => 'LinkedIn',           'slug' => 'linked',             'primary' => 1,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 1, 'link' => 'https://linkedin.com/',                          'summary' => 'A powerful professional networking site that connects professionals worldwide.'],
            [ 'id' => 10, 'name' => 'Monster',            'slug' => 'monster',            'primary' => 1,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 1, 'link' => 'https://monster.com/',                           'summary' => 'One of the longest-running job search sites that also offers many job search tools.' ],
            [ 'id' => 11, 'name' => 'SimplyHired',        'slug' => 'simplehired',        'primary' => 1,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 1, 'link' => 'https://simplyhired.com/',                       'summary' => 'Aggregates job listings from multiple sites into one location.' ],
            [ 'id' => 12, 'name' => 'VirtualVocations',   'slug' => 'virtualvocations',   'primary' => 1,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 1, 'link' => 'https://www.virtualvocations.com/',              'summary' => null ],
            [ 'id' => 13, 'name' => 'ZipRecruiter',       'slug' => 'ziprecruiter',       'primary' => 1,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 1, 'link' => 'https://ziprecruiter.com/',                      'summary' => ' Utilizes AI and the information from job seekers and recruiters to match job seekers to open positions.' ],
            [ 'id' => 14, 'name' => 'Robert Half',        'slug' => 'robert-half',        'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 0, 'link' => 'https://www.roberthalf.com/us/en/jobs',          'summary' => 'Focuses on roles in accounting, finance, IT, and marketing.' ],
            [ 'id' => 15, 'name' => 'CSS Staffing',       'slug' => 'css-staffing',       'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 0, 'link' => 'https://cssstaffing.com/search-open-positions/', 'summary' => null ],
            [ 'id' => 16, 'name' => 'TalentFish',         'slug' => 'talentfish',         'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 0, 'link' => 'https://talentfish.com/opportunities/',          'summary' => null ],
            [ 'id' => 17, 'name' => 'Trova',              'slug' => 'trova',              'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 0, 'link' => 'https://www.trovasearch.com/job-postings/',      'summary' => null ],
            [ 'id' => 18, 'name' => 'Horizontal Talent',  'slug' => 'horizontal-talent',  'primary' => 0,'local' => 1, 'regional' => 0, 'national' => 1, 'international' => 0, 'link' => 'https://www.horizontaltalent.com/job-board',     'summary' => null ],
            [ 'id' => 19, 'name' => 'Randstad USA',       'slug' => 'randstad-usa',       'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 0, 'link' => 'https://www.randstadusa.com/jobs/',              'summary' => null ],
            [ 'id' => 20, 'name' => 'CyberCoders',        'slug' => 'cybercoders',        'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 0, 'link' => 'https://www.cybercoders.com/search',             'summary' => null ],
            [ 'id' => 21, 'name' => 'RingSide Talent',    'slug' => 'ringside-talent',    'primary' => 0,'local' => 0, 'regional' => 1, 'national' => 0, 'international' => 0, 'link' => 'https://ringsidetalent.com/jobs/',               'summary' => null ],
            [ 'id' => 22, 'name' => 'RIT Solutions',      'slug' => 'rit-solutions',      'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 0, 'international' => 1, 'link' => 'https://ritsolinc.jobs.net/jobs',                'summary' => null ],
            [ 'id' => 23, 'name' => 'Vernovis',           'slug' => 'vernovis',           'primary' => 0,'local' => 0, 'regional' => 1, 'national' => 0, 'international' => 0, 'link' => 'https://vernovis.com/search-jobs/',              'summary' => null ],
            [ 'id' => 24, 'name' => 'Glassdoor',          'slug' => 'glassdoor',          'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 0, 'link' => 'https://www.glassdoor.com/',                     'summary' => 'A job search site that features feedback from employees at companies.' ],
            [ 'id' => 25, 'name' => 'Handshake',          'slug' => 'handshake',          'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 0, 'link' => 'https://joinhandshake.com/',                     'summary' => null ],
            [ 'id' => 26, 'name' => 'Hire Central',       'slug' => 'hire-central',       'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 0, 'international' => 1, 'link' => 'https://hirecentral.co/',                        'summary' => null ],
            [ 'id' => 27, 'name' => 'Craigslist',         'slug' => 'craigslist',         'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 0, 'international' => 1, 'link' => 'https://www.craigslist.org',                     'summary' => null ],
            [ 'id' => 28, 'name' => 'Talent.com',         'slug' => 'talent-com',         'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 0, 'link' => 'https://www.talent.com/',                        'summary' => null ],
            [ 'id' => 29, 'name' => 'FlexJobs',           'slug' => 'flexjobs',           'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 0, 'link' => 'https://www.flexjobs.com/',                      'summary' => 'Features rigorously vetted remote, work-from-home, and flexible job opportunities.' ],
            [ 'id' => 30, 'name' => 'CareerBuilder',      'slug' => 'careerbuilder',      'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 0, 'link' => 'https://www.careerbuilder.com/',                 'summary' => 'A job search site featuring listings, resume tools, job alerts, and labor market insights.' ],
            [ 'id' => 31, 'name' => 'Snagajob',           'slug' => 'snagajob',           'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 0, 'link' => 'https://www.snagajob.com/',                      'summary' => 'Focuses on hourly and shift-based jobs, catering to retail, restaurant, and seasonal work.' ],
            [ 'id' => 32, 'name' => 'Ladders',            'slug' => 'ladders',            'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 0, 'link' => 'https://www.theladders.com/',                    'summary' => 'Dedicated to helping professionals looking for high-paying roles.' ],
            [ 'id' => 33, 'name' => 'The Muse',           'slug' => 'the-muse',           'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 0, 'link' => 'https://www.themuse.com/',                       'summary' => null ],
            [ 'id' => 34, 'name' => 'Nexxt',              'slug' => 'Nexxt',              'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 0, 'link' => 'https://www.nexxt.com/',                         'summary' => 'Organizes job searches by career field that target specific careers, job seeker demographics, and geographical areas.'],
            [ 'id' => 35, 'name' => 'CareerBliss',        'slug' => 'CareerBliss',        'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 0, 'link' => 'https://www.careerbliss.com/',                   'summary' => null ],
            [ 'id' => 36, 'name' => 'We Work Remotely',   'slug' => 'we-work-remotely',   'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 0, 'link' => 'https://weworkremotely.com/',                    'summary' => null ],
            [ 'id' => 37, 'name' => 'The Job Network',    'slug' => 'the-job-network',    'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 0, 'link' => 'https://www.thejobnetwork.com/',                 'summary' => null ],
            [ 'id' => 38, 'name' => 'Adzuna',             'slug' => 'adzuna',             'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 0, 'international' => 1, 'link' => 'https://www.adzuna.com/',                        'summary' => null ],
            [ 'id' => 39, 'name' => 'Geebo',              'slug' => 'geebo',              'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 0, 'link' => 'https://geebo.com/',                             'summary' => null ],
            [ 'id' => 40, 'name' => 'ClearanceJobs',      'slug' => 'clearancejobs',      'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 0, 'link' => 'https://www.clearancejobs.com/',                 'summary' => null ],
            [ 'id' => 41, 'name' => 'Jobs Juju',          'slug' => 'jobs-juju',          'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 0, 'link' => 'https://www.jobsjuju.com/',                      'summary' => null ],
            [ 'id' => 42, 'name' => 'College Recruiter',  'slug' => 'college-recruiter',  'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 0, 'link' => 'https://www.collegerecruiter.com/',              'summary' => null ],
            [ 'id' => 43, 'name' => 'Careerjet',          'slug' => 'careerjet',          'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 0, 'link' => 'https://www.careerjet.com/',                     'summary' => null ],
            [ 'id' => 44, 'name' => 'Wellfound',          'slug' => 'wellfound',          'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 0, 'link' => 'https://wellfound.com/',                         'summary' => 'A platform for startup job seekers with curated listings. (formerly AngelList Talent)' ],
            [ 'id' => 45, 'name' => 'Getwork',            'slug' => 'getwork',            'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 0, 'link' => 'https://www.getwork.com/',                       'summary' => 'A job aggregator website that lists verified job postings directly from employer websites. (formerly LinkUp)' ],
            [ 'id' => 46, 'name' => 'Remote.co',          'slug' => 'remote-co',          'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 0, 'link' => 'https://remote.co/',                             'summary' => 'Specializes in remote jobs. Sister site of FlexJobs.' ],
            [ 'id' => 47, 'name' => 'Fiverr',             'slug' => 'fiverr',             'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 0, 'link' => 'https://www.fiverr.com/',                        'summary' => 'A freelance marketplace where professionals offer services across categories like writing, design, marketing, and programming.' ],
            [ 'id' => 48, 'name' => 'GovernmentJobs.com', 'slug' => 'governmentjobs-com', 'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 0, 'link' => 'https://www.governmentjobs.com/',                'summary' => 'A centralized job board for public sector careers across federal, state, and local agencies.' ],
            [ 'id' => 49, 'name' => 'HigherEdJobs',       'slug' => 'higheredjobs',       'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 0, 'link' => 'https://www.higheredjobs.com/',                  'summary' => 'Specializes in employment opportunities within colleges, universities, and academic institutions.' ],
            [ 'id' => 50, 'name' => 'HiringCafe',         'slug' => 'hiringCafe',         'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 0, 'link' => 'https://hiring.cafe/',                           'summary' => 'Features curated listings, employer profiles, and tools designed to simplify the application process.' ],
            [ 'id' => 51, 'name' => 'Job.com',            'slug' => 'job-com',            'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 0, 'link' => 'https://job.com/',                               'summary' => 'Combines traditional job listings with automated matching tools.' ],
            [ 'id' => 52, 'name' => 'Joblist',            'slug' => 'joblist',            'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 0, 'link' => 'https://www.joblist.com/',                       'summary' => 'Combines listings from multiple sources and tailoring results to individual preferences.' ],
            [ 'id' => 53, 'name' => 'Simplify',           'slug' => 'simplify',           'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 0, 'link' => 'https://simplify.jobs/',                         'summary' => 'Helps candidates streamline their applications through autofill features, job tracking, and curated role recommendations.' ],
            [ 'id' => 54, 'name' => 'Upwork',             'slug' => 'upwork',             'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 0, 'link' => 'https://www.upwork.com/',                        'summary' => 'A marketplace where freelancers post their services.' ],
            //[ 'id' => #, 'name' => '',       'slug' => '',       'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 0, 'international' => 0, 'link' => '', 'summary' => null ],
        ];


        // add timestamps
        for($i=0; $i<count($data);$i++) {
            $data[$i]['is_public'] = true;
            $data[$i]['is_root'] = true;
            $data[$i]['created_at'] = now();
            $data[$i]['updated_at'] = now();
        }

        DB::connection($this->database_tag)->table($this->table_name)->insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->database_tag)->dropIfExists($this->table_name);
    }
};
