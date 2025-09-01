<?php

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
            $table->string('website')->nullable();
            $table->text('description')->nullable();
            $table->integer('sequence')->default(0);
            $table->tinyInteger('public')->default(1);
            $table->integer('readonly')->default(0);
            $table->integer('root')->default(1);
            $table->tinyInteger('disabled')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        $data = [
            [ 'id' => 1,  'name' => 'Dice',             'slug' => 'dice',             'website' => 'https://dice.com/' ],
            [ 'id' => 2,  'name' => 'Indeed',           'slug' => 'indeed',           'website' => 'https://indeed.com/' ],
            [ 'id' => 3,  'name' => 'iHireTechnology',  'slug' => 'ihiretechnology',  'website' => 'https://ihiretechnology.com/' ],
            [ 'id' => 4,  'name' => 'JobLeads',         'slug' => 'jobleads',         'website' => 'https://jobleads.com/' ],
            [ 'id' => 5,  'name' => 'Jobright',         'slug' => 'jobright',         'website' => 'https://jobright.ai/' ],
            [ 'id' => 6,  'name' => 'LaraJobs',         'slug' => 'larajobs',         'website' => 'https://larajobs.com/' ],
            [ 'id' => 7,  'name' => 'Lensa',            'slug' => 'lensa',            'website' => 'https://lensa.com/' ],
            [ 'id' => 8,  'name' => 'LinkedIn',         'slug' => 'linked',           'website' => 'https://linkedin.com/' ],
            [ 'id' => 9,  'name' => 'Monster',          'slug' => 'monster',          'website' => 'https://monster.com/' ],
            [ 'id' => 10, 'name' => 'SimplyHired',      'slug' => 'simplehired',      'website' => 'https://simplyhired.com/' ],
            [ 'id' => 11, 'name' => 'VirtualVocations', 'slug' => 'virtualvocations', 'website' => 'https://www.virtualvocations.com/' ],
            [ 'id' => 12, 'name' => 'ZipRecruiter',     'slug' => 'ziprecruiter',     'website' => 'https://ziprecruiter.com/' ],
        ];
        App\Models\Career\JobBoard::insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('career_db')->dropIfExists('job_boards');
    }
};
