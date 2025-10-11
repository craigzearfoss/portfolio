<?php

use App\Models\System\UserTeam;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $database_tag = 'core_db';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection($this->database_tag)->create('user_teams', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\System\Owner::class, 'owner_id');
            $table->string('name', 100);
            $table->string('slug', 100)->unique();
            $table->string('abbreviation', 20)->nullable();
            $table->text('description')->nullable();
            $table->tinyInteger('disabled')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        $data = [
            [
                'id'           => 1,
                'owner_id'     => 2,
                'name'         => 'Default User Team',
                'slug'         => 'default-user-team',
                'abbreviation' => 'DUT',
            ],
        ];

        // add timestamps
        for($i=0; $i<count($data);$i++) {
            $data[$i]['created_at'] = now();
            $data[$i]['updated_at'] = now();
        }

        UserTeam::insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->database_tag)->dropIfExists('user_teams');
    }
};
