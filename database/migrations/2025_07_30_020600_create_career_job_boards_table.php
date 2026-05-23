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
            [ 'id' => 1,  'name' => 'other',                   'slug' => 'other',                   'primary' => 1,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 0, 'email' => null,                 'link' => null,                                             'summary' => null ],
            [ 'id' => 2,  'name' => 'Dice',                    'slug' => 'dice',                    'primary' => 1,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 1, 'email' => null,                 'link' => 'https://dice.com/',                              'summary' => 'An industry-specific job site serving the technology and IT fields.' ],
            [ 'id' => 3,  'name' => 'Indeed',                  'slug' => 'indeed',                  'primary' => 1,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 1, 'email' => null,                 'link' => 'https://indeed.com/',                            'summary' => 'One of the world\’s largest job boards.' ],
            [ 'id' => 4,  'name' => 'iHireTechnology',         'slug' => 'ihiretechnology',         'primary' => 1,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 1, 'email' => null,                 'link' => 'https://ihiretechnology.com/',                   'summary' => 'Features targeted job listings, resume-matching tools, and job alert emails.' ],
            [ 'id' => 5,  'name' => 'JobLeads',                'slug' => 'jobleads',                'primary' => 1,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 1, 'email' => null,                 'link' => 'https://jobleads.com/',                          'summary' => 'Subscription-base service that features curated job opportunities and resume services.' ],
            [ 'id' => 6,  'name' => 'Jobright',                'slug' => 'jobright',                'primary' => 1,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 1, 'email' => null,                 'link' => 'https://jobright.ai/',                           'summary' => 'An AI-powered job search assistant for streamlining applications and resume tailoring.' ],
            [ 'id' => 7,  'name' => 'LaraJobs',                'slug' => 'larajobs',                'primary' => 1,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 1, 'email' => null,                 'link' => 'https://larajobs.com/',                          'summary' => 'The official and premier job board for Laravel developers.' ],
            [ 'id' => 8,  'name' => 'Lensa',                   'slug' => 'lensa',                   'primary' => 1,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 1, 'email' => null,                 'link' => 'https://lensa.com/',                             'summary' => 'A job search engine and aggregator.' ],
            [ 'id' => 9,  'name' => 'LinkedIn',                'slug' => 'linked',                  'primary' => 1,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 1, 'email' => null,                 'link' => 'https://linkedin.com/',                          'summary' => 'A powerful professional networking site that connects professionals worldwide.'],
            [ 'id' => 10, 'name' => 'Monster',                 'slug' => 'monster',                 'primary' => 1,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 1, 'email' => null,                 'link' => 'https://monster.com/',                           'summary' => 'One of the longest-running job search sites that also offers many job search tools.' ],
            [ 'id' => 11, 'name' => 'SimplyHired',             'slug' => 'simplehired',             'primary' => 1,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 1, 'email' => null,                 'link' => 'https://simplyhired.com/',                       'summary' => 'Aggregates job listings from multiple sites into one location.' ],
            [ 'id' => 12, 'name' => 'VirtualVocations',        'slug' => 'virtualvocations',        'primary' => 1,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 1, 'email' => null,                 'link' => 'https://www.virtualvocations.com/',              'summary' => 'Subscription-based US-focused remote job board and aggregation service ' ],
            [ 'id' => 13, 'name' => 'ZipRecruiter',            'slug' => 'ziprecruiter',            'primary' => 1,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 1, 'email' => null,                 'link' => 'https://ziprecruiter.com/',                      'summary' => 'Utilizes AI and the information from job seekers and recruiters to match job seekers to open positions.' ],
            [ 'id' => 14, 'name' => 'Robert Half',             'slug' => 'robert-half',             'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 0, 'email' => null,                 'link' => 'https://www.roberthalf.com/us/en/jobs',          'summary' => 'Focuses on roles in accounting, finance, IT, and marketing.' ],
            [ 'id' => 15, 'name' => 'CSS Staffing',            'slug' => 'css-staffing',            'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 0, 'email' => null,                 'link' => 'https://cssstaffing.com/search-open-positions/', 'summary' => null ],
            [ 'id' => 16, 'name' => 'TalentFish',              'slug' => 'talentfish',              'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 0, 'email' => null,                 'link' => 'https://talentfish.com/opportunities/',          'summary' => null ],
            [ 'id' => 17, 'name' => 'Trova',                   'slug' => 'trova',                   'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 0, 'email' => null,                 'link' => 'https://www.trovasearch.com/job-postings/',      'summary' => null ],
            [ 'id' => 18, 'name' => 'Horizontal Talent',       'slug' => 'horizontal-talent',       'primary' => 0,'local' => 1, 'regional' => 0, 'national' => 1, 'international' => 0, 'email' => null,                 'link' => 'https://www.horizontaltalent.com/job-board',     'summary' => null ],
            [ 'id' => 19, 'name' => 'Randstad USA',            'slug' => 'randstad-usa',            'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 0, 'email' => null,                 'link' => 'https://www.randstadusa.com/jobs/',              'summary' => null ],
            [ 'id' => 20, 'name' => 'CyberCoders',             'slug' => 'cybercoders',             'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 0, 'email' => null,                 'link' => 'https://www.cybercoders.com/search',             'summary' => null ],
            [ 'id' => 21, 'name' => 'RingSide Talent',         'slug' => 'ringside-talent',         'primary' => 0,'local' => 0, 'regional' => 1, 'national' => 0, 'international' => 0, 'email' => null,                 'link' => 'https://ringsidetalent.com/jobs/',               'summary' => null ],
            [ 'id' => 22, 'name' => 'RIT Solutions',           'slug' => 'rit-solutions',           'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 0, 'international' => 1, 'email' => null,                 'link' => 'https://ritsolinc.jobs.net/jobs',                'summary' => null ],
            [ 'id' => 23, 'name' => 'Vernovis',                'slug' => 'vernovis',                'primary' => 0,'local' => 0, 'regional' => 1, 'national' => 0, 'international' => 0, 'email' => null,                 'link' => 'https://vernovis.com/search-jobs/',              'summary' => null ],
            [ 'id' => 24, 'name' => 'Glassdoor',               'slug' => 'glassdoor',               'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 0, 'email' => null,                 'link' => 'https://www.glassdoor.com/',                     'summary' => 'A job search site that features feedback from employees at companies.' ],
            [ 'id' => 25, 'name' => 'Handshake',               'slug' => 'handshake',               'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 0, 'email' => null,                 'link' => 'https://joinhandshake.com/',                     'summary' => 'An early-career network, partnering directly with universities to connect students with employers.' ],
            [ 'id' => 26, 'name' => 'Hire Central',            'slug' => 'hire-central',            'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 0, 'international' => 1, 'email' => null,                 'link' => 'https://hirecentral.co/',                        'summary' => 'Offers AI-powered tools for resume screening, candidate scoring, and chatbot assessments.' ],
            [ 'id' => 27, 'name' => 'Craigslist',              'slug' => 'craigslist',              'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 0, 'international' => 1, 'email' => null,                 'link' => 'https://www.craigslist.org',                     'summary' => null ],
            [ 'id' => 28, 'name' => 'Talent.com',              'slug' => 'talent-com',              'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 0, 'email' => null,                 'link' => 'https://www.talent.com/',                        'summary' => null ],
            [ 'id' => 29, 'name' => 'FlexJobs',                'slug' => 'flexjobs',                'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 0, 'email' => null,                 'link' => 'https://www.flexjobs.com/',                      'summary' => 'Features rigorously vetted remote, work-from-home, and flexible job opportunities.' ],
            [ 'id' => 30, 'name' => 'CareerBuilder',           'slug' => 'careerbuilder',           'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 0, 'email' => null,                 'link' => 'https://www.careerbuilder.com/',                 'summary' => 'A job search site featuring listings, resume tools, job alerts, and labor market insights.' ],
            [ 'id' => 31, 'name' => 'Snagajob',                'slug' => 'snagajob',                'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 0, 'email' => null,                 'link' => 'https://www.snagajob.com/',                      'summary' => 'Focuses on hourly and shift-based jobs, catering to retail, restaurant, and seasonal work.' ],
            [ 'id' => 32, 'name' => 'Ladders',                 'slug' => 'ladders',                 'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 0, 'email' => null,                 'link' => 'https://www.theladders.com/',                    'summary' => 'Dedicated to helping professionals looking for high-paying roles.' ],
            [ 'id' => 33, 'name' => 'The Muse',                'slug' => 'the-muse',                'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 0, 'email' => null,                 'link' => 'https://www.themuse.com/',                       'summary' => null ],
            [ 'id' => 34, 'name' => 'Nexxt',                   'slug' => 'Nexxt',                   'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 0, 'email' => null,                 'link' => 'https://www.nexxt.com/',                         'summary' => 'Organizes job searches by career field that target specific careers, job seeker demographics, and geographical areas.'],
            [ 'id' => 35, 'name' => 'CareerBliss',             'slug' => 'CareerBliss',             'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 0, 'email' => null,                 'link' => 'https://www.careerbliss.com/',                   'summary' => null ],
            [ 'id' => 36, 'name' => 'We Work Remotely',        'slug' => 'we-work-remotely',        'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 0, 'email' => null,                 'link' => 'https://weworkremotely.com/',                    'summary' => null ],
            [ 'id' => 37, 'name' => 'The Job Network',         'slug' => 'the-job-network',         'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 0, 'email' => null,                 'link' => 'https://www.thejobnetwork.com/',                 'summary' => null ],
            [ 'id' => 38, 'name' => 'Adzuna',                  'slug' => 'adzuna',                  'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 0, 'international' => 1, 'email' => null,                 'link' => 'https://www.adzuna.com/',                        'summary' => null ],
            [ 'id' => 39, 'name' => 'Geebo',                   'slug' => 'geebo',                   'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 0, 'email' => null,                 'link' => 'https://geebo.com/',                             'summary' => null ],
            [ 'id' => 40, 'name' => 'ClearanceJobs',           'slug' => 'clearancejobs',           'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 0, 'email' => null,                 'link' => 'https://www.clearancejobs.com/',                 'summary' => null ],
            [ 'id' => 41, 'name' => 'Jobs Juju',               'slug' => 'jobs-juju',               'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 0, 'email' => null,                 'link' => 'https://www.jobsjuju.com/',                      'summary' => null ],
            [ 'id' => 42, 'name' => 'College Recruiter',       'slug' => 'college-recruiter',       'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 0, 'email' => null,                 'link' => 'https://www.collegerecruiter.com/',              'summary' => null ],
            [ 'id' => 43, 'name' => 'Careerjet',               'slug' => 'careerjet',               'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 0, 'email' => null,                 'link' => 'https://www.careerjet.com/',                     'summary' => 'Gives job seekers direct access to an extensive database of jobs, targeted to their needs, in just one straight forward search.' ],
            [ 'id' => 44, 'name' => 'Wellfound',               'slug' => 'wellfound',               'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 0, 'email' => null,                 'link' => 'https://wellfound.com/',                         'summary' => 'A platform for startup job seekers with curated listings. (formerly AngelList Talent)' ],
            [ 'id' => 45, 'name' => 'Getwork',                 'slug' => 'getwork',                 'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 0, 'email' => null,                 'link' => 'https://www.getwork.com/',                       'summary' => 'A job aggregator website that lists verified job postings directly from employer websites. (formerly LinkUp)' ],
            [ 'id' => 46, 'name' => 'Remote.co',               'slug' => 'remote-co',               'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 0, 'email' => null,                 'link' => 'https://remote.co/',                             'summary' => 'Specializes in remote jobs. Sister site of FlexJobs.' ],
            [ 'id' => 47, 'name' => 'Fiverr',                  'slug' => 'fiverr',                  'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 0, 'email' => null,                 'link' => 'https://www.fiverr.com/',                        'summary' => 'A freelance marketplace where professionals offer services across categories like writing, design, marketing, and programming.' ],
            [ 'id' => 48, 'name' => 'GovernmentJobs.com',      'slug' => 'governmentjobs-com',      'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 0, 'email' => null,                 'link' => 'https://www.governmentjobs.com/',                'summary' => 'A centralized job board for public sector careers across federal, state, and local agencies.' ],
            [ 'id' => 49, 'name' => 'HigherEdJobs',            'slug' => 'higheredjobs',            'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 0, 'email' => null,                 'link' => 'https://www.higheredjobs.com/',                  'summary' => 'Specializes in employment opportunities within colleges, universities, and academic institutions.' ],
            [ 'id' => 50, 'name' => 'HiringCafe',              'slug' => 'hiringCafe',              'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 0, 'email' => null,                 'link' => 'https://hiring.cafe/',                           'summary' => 'Features curated listings, employer profiles, and tools designed to simplify the application process.' ],
            [ 'id' => 51, 'name' => 'Job.com',                 'slug' => 'job-com',                 'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 0, 'email' => null,                 'link' => 'https://job.com/',                               'summary' => 'Combines traditional job listings with automated matching tools.' ],
            [ 'id' => 52, 'name' => 'Joblist',                 'slug' => 'joblist',                 'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 0, 'email' => null,                 'link' => 'https://www.joblist.com/',                       'summary' => 'Combines listings from multiple sources and tailoring results to individual preferences.' ],
            [ 'id' => 53, 'name' => 'Simplify',                'slug' => 'simplify',                'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 0, 'email' => null,                 'link' => 'https://simplify.jobs/',                         'summary' => 'Helps candidates streamline their applications through autofill features, job tracking, and curated role recommendations.' ],
            [ 'id' => 54, 'name' => 'Upwork',                  'slug' => 'upwork',                  'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 0, 'email' => null,                 'link' => 'https://www.upwork.com/',                        'summary' => 'A marketplace where freelancers post their services.' ],
            [ 'id' => 55, 'name' => 'Welcome to the Jungle',   'slug' => 'welcome-to-the-jungle',   'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 0, 'email' => null,                 'link' => 'https://www.welcometothejungle.com/en',          'summary' => 'Focused heavily on employer branding, video content, and deep dives into company culture.' ],
            [ 'id' => 56, 'name' => 'Remote Rocketship',       'slug' => 'remote-rocketship',       'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 0, 'email' => null,                 'link' => 'https://www.remoterocketship.com/',              'summary' => 'Curated subscription-based job board for remote positions.' ],
            [ 'id' => 57, 'name' => 'Snaphunt',                'slug' => 'snaphunt',                'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 1, 'email' => null,                 'link' => 'https://snaphunt.com/',                          'summary' => 'Job board with paid plans that has a robust talent pool and automated screening tools.' ],
            [ 'id' => 58, 'name' => 'Remotive',                'slug' => 'remotive',                'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 1, 'email' => 'hello@remotive.com', 'link' => 'https://remotive.com/',                          'summary' => 'Features fully remote jobs from vetted companies.' ],
            [ 'id' => 59, 'name' => 'RemoteHub',               'slug' => 'remotehub',               'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 1, 'email' => 'info@remotehub.com', 'link' => 'https://www.remotehub.com/',                     'summary' => 'Job aggregator site that features remote roles across various industries.' ],
            [ 'id' => 60, 'name' => 'Real Work From Anywhere', 'slug' => 'real-work-from-anywhere', 'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 1, 'email' => null,                 'link' => 'https://www.realworkfromanywhere.com/',          'summary' => 'A fully location independent job board.' ],
            [ 'id' => 61, 'name' => 'DailyRemote',             'slug' => 'dailyremote',             'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 1, 'email' => null,                 'link' => 'https://dailyremote.com/',                       'summary' => 'A popular job board that aggregates remote and work-from-home opportunities globally.' ],
            [ 'id' => 62, 'name' => 'Working Nomads',          'slug' => 'working-nomads',          'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 1, 'email' => null,                 'link' => 'https://www.workingnomads.com/',                 'summary' => 'A streamlined job board for 100% remote professionals.' ],
            [ 'id' => 63, 'name' => 'RemoteJobsFinder.co',     'slug' => 'remotejobsfinder-co',     'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 1, 'email' => null,                 'link' => 'https://remotejobsfinder.co/',                   'summary' => 'A paid aggregator that charges for publicly available remote jobs.' ],
            [ 'id' => 64, 'name' => 'Naukri',                  'slug' => 'naukri',                  'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 1, 'email' => null,                 'link' => 'https://www.naukri.com/',                        'summary' => 'An extensive job database and intuitive interface that offers paid premium services.' ],
            [ 'id' => 65, 'name' => 'Just Join IT',            'slug' => 'just-join-it',            'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 0, 'international' => 1, 'email' => null,                 'link' => 'https://justjoin.it/',                           'summary' => 'Job board for the tech industry in Europe that strictly mandates the inclusion of salary range.' ],
            [ 'id' => 66, 'name' => 'Hubstaff Talent',         'slug' => 'hubstaff-talent',         'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 1, 'email' => null,                 'link' => 'https://hubstafftalent.net/',                    'summary' => 'An entirely free job board with global reach.' ],
            [ 'id' => 67, 'name' => 'MeeBoss',                 'slug' => 'meeboss',                 'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 0, 'email' => null,                 'link' => 'https://meeboss.com/',                           'summary' => 'A chat-first job matching platform that replaces traditional resumes with AI-curated direct messaging between job seekers and hiring managers.' ],
            [ 'id' => 68, 'name' => 'HireBasis',               'slug' => 'hirebasis',               'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 0, 'email' => null,                 'link' => 'https://www.hirebasis.com/',                     'summary' => 'Pre-vetted global remote jobs.' ],
            //[ 'id' => #, 'name' => '',       'slug' => '',       'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 0, 'email' => null,                 'link' => '', 'summary' => null ],
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
