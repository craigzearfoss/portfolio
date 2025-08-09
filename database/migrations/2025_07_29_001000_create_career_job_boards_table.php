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
            $table->string('website')->nullable();
        });

        $data = [
            [ 'name' => 'Dice',             'website' => 'https://dice.com/' ],
            [ 'name' => 'Indeed',           'website' => 'https://indeed.com/' ],
            [ 'name' => 'iHireTechnology',  'website' => 'https://ihiretechnology.com/' ],
            [ 'name' => 'JobLeads',         'website' => 'https://jobleads.com/' ],
            [ 'name' => 'Jobright',         'website' => 'https://jobright.ai/' ],
            [ 'name' => 'Lensa',            'website' => 'https://lensa.com/' ],
            [ 'name' => 'LinkedIn',         'website' => 'https://linkedin.com/' ],
            [ 'name' => 'Monster',          'website' => 'https://monster.com/' ],
            [ 'name' => 'SimplyHired',      'website' => 'https://simplyhired.com/' ],
            [ 'name' => 'VirtualVocations', 'website' => 'https://www.virtualvocations.com/' ],
            [ 'name' => 'ZipRecruiter',     'website' => 'https://ziprecruiter.com/' ],
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
