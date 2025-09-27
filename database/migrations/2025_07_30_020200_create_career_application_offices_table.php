<?php

use App\Models\Career\ApplicationOffice;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * The tag used to identify the career database.
     *
     * @var string
     */
    protected $database_tag = 'career_db';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection($this->database_tag)->create('application_offices', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->unique();
            $table->string('abbreviation', 20)->unique();
        });

        $data = [
            [
                'id'           => 1,
                'name'         => 'onsite',
                'abbreviation' => 'on',
            ],
            [
                'id'           => 2,
                'name'         => 'remote',
                'abbreviation' => 'rm',
            ],
            [
                'id'           => 3,
                'name'         => 'hybrid',
                'abbreviation' => 'hy',
            ],
        ];

        ApplicationOffice::insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->database_tag)->dropIfExists('application_offices');
    }
};
