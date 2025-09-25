<?php

use App\Models\Career\JobBoard;
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
        Schema::connection('career_db')->create('job_boards', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique();
            $table->string('slug', 100)->unique();
            $table->tinyInteger('primary')->default(0);
            $table->tinyInteger('local')->default(0);
            $table->tinyInteger('regional')->default(0);
            $table->tinyInteger('national')->default(0);
            $table->tinyInteger('international')->default(0);
            $table->string('link')->nullable();
            $table->string('link_name')->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->string('image_credit')->nullable();
            $table->string('image_source')->nullable();
            $table->string('thumbnail')->nullable();
            $table->integer('sequence')->default(0);
            $table->tinyInteger('public')->default(1);
            $table->tinyInteger('readonly')->default(0);
            $table->tinyInteger('root')->default(1);
            $table->tinyInteger('disabled')->default(0);
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
        ];

        JobBoard::insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('career_db')->dropIfExists('job_boards');
    }
};
