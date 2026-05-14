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
            [ 'id' => 1,  'name' => 'other',             'slug' => 'other',             'primary' => 1,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 0, 'link' => null ],
            [ 'id' => 2,  'name' => 'Dice',              'slug' => 'dice',              'primary' => 1,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 1, 'link' => 'https://dice.com/' ],
            [ 'id' => 3,  'name' => 'Indeed',            'slug' => 'indeed',            'primary' => 1,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 1, 'link' => 'https://indeed.com/' ],
            [ 'id' => 4,  'name' => 'iHireTechnology',   'slug' => 'ihiretechnology',   'primary' => 1,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 1, 'link' => 'https://ihiretechnology.com/' ],
            [ 'id' => 5,  'name' => 'JobLeads',          'slug' => 'jobleads',          'primary' => 1,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 1, 'link' => 'https://jobleads.com/' ],
            [ 'id' => 6,  'name' => 'Jobright',          'slug' => 'jobright',          'primary' => 1,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 1, 'link' => 'https://jobright.ai/' ],
            [ 'id' => 7,  'name' => 'LaraJobs',          'slug' => 'larajobs',          'primary' => 1,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 1, 'link' => 'https://larajobs.com/' ],
            [ 'id' => 8,  'name' => 'Lensa',             'slug' => 'lensa',             'primary' => 1,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 1, 'link' => 'https://lensa.com/' ],
            [ 'id' => 9,  'name' => 'LinkedIn',          'slug' => 'linked',            'primary' => 1,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 1, 'link' => 'https://linkedin.com/' ],
            [ 'id' => 10, 'name' => 'Monster',           'slug' => 'monster',           'primary' => 1,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 1, 'link' => 'https://monster.com/' ],
            [ 'id' => 11, 'name' => 'SimplyHired',       'slug' => 'simplehired',       'primary' => 1,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 1, 'link' => 'https://simplyhired.com/' ],
            [ 'id' => 12, 'name' => 'VirtualVocations',  'slug' => 'virtualvocations',  'primary' => 1,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 1, 'link' => 'https://www.virtualvocations.com/' ],
            [ 'id' => 13, 'name' => 'ZipRecruiter',      'slug' => 'ziprecruiter',      'primary' => 1,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 1, 'link' => 'https://ziprecruiter.com/' ],
            [ 'id' => 14, 'name' => 'Robert Half',       'slug' => 'robert-half',       'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 0, 'link' => 'https://www.roberthalf.com/us/en/jobs' ],
            [ 'id' => 15, 'name' => 'CSS Staffing',      'slug' => 'css-staffing',      'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 0, 'link' => 'https://cssstaffing.com/search-open-positions/' ],
            [ 'id' => 16, 'name' => 'TalentFish',        'slug' => 'talentfish',        'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 0, 'link' => 'https://talentfish.com/opportunities/' ],
            [ 'id' => 17, 'name' => 'Trova',             'slug' => 'trova',             'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 0, 'link' => 'https://www.trovasearch.com/job-postings/' ],
            [ 'id' => 18, 'name' => 'Horizontal Talent', 'slug' => 'horizontal-talent', 'primary' => 0,'local' => 1, 'regional' => 0, 'national' => 1, 'international' => 0, 'link' => 'https://www.horizontaltalent.com/job-board' ],
            [ 'id' => 19, 'name' => 'Randstad USA',      'slug' => 'randstad-usa',      'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 0, 'link' => 'https://www.randstadusa.com/jobs/' ],
            [ 'id' => 20, 'name' => 'CyberCoders',       'slug' => 'cybercoders',       'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 0, 'link' => 'https://www.cybercoders.com/search' ],
            [ 'id' => 21, 'name' => 'RingSide Talent',   'slug' => 'ringside-talent',   'primary' => 0,'local' => 0, 'regional' => 1, 'national' => 0, 'international' => 0, 'link' => 'https://ringsidetalent.com/jobs/' ],
            [ 'id' => 22, 'name' => 'RIT Solutions',     'slug' => 'rit-solutions',     'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 0, 'international' => 1, 'link' => 'https://ritsolinc.jobs.net/jobs' ],
            [ 'id' => 23, 'name' => 'Vernovis',          'slug' => 'vernovis',          'primary' => 0,'local' => 0, 'regional' => 1, 'national' => 0, 'international' => 0, 'link' => 'https://vernovis.com/search-jobs/' ],
            [ 'id' => 24, 'name' => 'Glassdoor',         'slug' => 'glassdoor',         'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 0, 'link' => 'https://www.glassdoor.com/' ],
            [ 'id' => 25, 'name' => 'Handshake',         'slug' => 'handshake',         'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 0, 'link' => 'https://joinhandshake.com/' ],
            [ 'id' => 26, 'name' => 'Hire Central',      'slug' => 'hire-central',      'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 0, 'international' => 1, 'link' => 'https://hirecentral.co/' ],
            [ 'id' => 27, 'name' => 'Craigslist',        'slug' => 'craigslist',        'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 0, 'international' => 1, 'link' => 'https://www.craigslist.org' ],
            [ 'id' => 28, 'name' => 'Talent.com',        'slug' => 'talent-com',         'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 0, 'link' => 'https://www.talent.com/' ],
            [ 'id' => 29, 'name' => 'FlexJobs',          'slug' => 'flexjobs',           'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 0, 'link' => 'https://www.flexjobs.com/' ],
            [ 'id' => 30, 'name' => 'CareerBuilder',     'slug' => 'careerbuilder',      'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 0, 'link' => 'https://www.careerbuilder.com/' ],
            [ 'id' => 31, 'name' => 'Snagajob',          'slug' => 'snagajob',           'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 0, 'link' => 'https://www.snagajob.com/' ],
            [ 'id' => 32, 'name' => 'Ladders',           'slug' => 'ladders',            'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 0, 'link' => 'https://www.theladders.com/' ],
            [ 'id' => 33, 'name' => 'The Muse',          'slug' => 'the-muse',           'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 0, 'link' => 'https://www.themuse.com/' ],
            [ 'id' => 34, 'name' => 'Nexxt',             'slug' => 'Nexxt',              'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 0, 'link' => 'https://www.nexxt.com/' ],
            [ 'id' => 35, 'name' => 'CareerBliss',       'slug' => 'CareerBliss',        'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 0, 'link' => 'https://www.careerbliss.com/' ],
            [ 'id' => 36, 'name' => 'We Work Remotely',  'slug' => 'we-work-remotely',   'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 0, 'link' => 'https://weworkremotely.com/' ],
            [ 'id' => 37, 'name' => 'The Job Network',   'slug' => 'the-job-network',    'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 0, 'link' => 'https://www.thejobnetwork.com/' ],
            [ 'id' => 38, 'name' => 'Adzuna',            'slug' => 'adzuna',             'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 0, 'international' => 1, 'link' => 'https://www.adzuna.com/' ],
            [ 'id' => 39, 'name' => 'Geebo',             'slug' => 'geebo',              'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 0, 'link' => 'https://geebo.com/' ],
            [ 'id' => 40, 'name' => 'ClearanceJobs',     'slug' => 'clearancejobs',      'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 0, 'link' => 'https://www.clearancejobs.com/' ],
            [ 'id' => 41, 'name' => 'Jobs Juju',         'slug' => 'jobs-juju',          'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 0, 'link' => 'https://www.jobsjuju.com/' ],
            [ 'id' => 42, 'name' => 'College Recruiter', 'slug' => 'college-recruiter',  'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 0, 'link' => 'https://www.collegerecruiter.com/' ],
            [ 'id' => 43, 'name' => 'Careerjet',         'slug' => 'careerjet',          'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 0, 'link' => 'https://www.careerjet.com/' ],
            [ 'id' => 44, 'name' => 'Wellfound',         'slug' => 'wellfound',          'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 1, 'international' => 0, 'link' => 'https://wellfound.com/' ],
            //[ 'id' => #, 'name' => '',       'slug' => '',       'primary' => 0,'local' => 0, 'regional' => 0, 'national' => 0, 'international' => 0, 'link' => '' ],
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
