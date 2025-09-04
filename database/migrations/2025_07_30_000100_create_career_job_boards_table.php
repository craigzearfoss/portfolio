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
            [ 'id' => 1,  'name' => 'Dice',             'slug' => 'dice',             'link' => 'https://dice.com/' ],
            [ 'id' => 2,  'name' => 'Indeed',           'slug' => 'indeed',           'link' => 'https://indeed.com/' ],
            [ 'id' => 3,  'name' => 'iHireTechnology',  'slug' => 'ihiretechnology',  'link' => 'https://ihiretechnology.com/' ],
            [ 'id' => 4,  'name' => 'JobLeads',         'slug' => 'jobleads',         'link' => 'https://jobleads.com/' ],
            [ 'id' => 5,  'name' => 'Jobright',         'slug' => 'jobright',         'link' => 'https://jobright.ai/' ],
            [ 'id' => 6,  'name' => 'LaraJobs',         'slug' => 'larajobs',         'link' => 'https://larajobs.com/' ],
            [ 'id' => 7,  'name' => 'Lensa',            'slug' => 'lensa',            'link' => 'https://lensa.com/' ],
            [ 'id' => 8,  'name' => 'LinkedIn',         'slug' => 'linked',           'link' => 'https://linkedin.com/' ],
            [ 'id' => 9,  'name' => 'Monster',          'slug' => 'monster',          'link' => 'https://monster.com/' ],
            [ 'id' => 10, 'name' => 'SimplyHired',      'slug' => 'simplehired',      'link' => 'https://simplyhired.com/' ],
            [ 'id' => 11, 'name' => 'VirtualVocations', 'slug' => 'virtualvocations', 'link' => 'https://www.virtualvocations.com/' ],
            [ 'id' => 12, 'name' => 'ZipRecruiter',     'slug' => 'ziprecruiter',     'link' => 'https://ziprecruiter.com/' ],
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
