<?php

use App\Models\System\User;
use App\Models\System\UserGroup;
use App\Models\System\UserUserGroup;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * @var string
     */
    protected string $database_tag = 'system_db';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection($this->database_tag)->create('user_user_group', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained('users', 'id')
                ->onDelete('cascade');
            $table->foreignId('user_group_id')
                ->constrained('user_groups', 'id')
                ->onDelete('cascade');
        });

        $data = [
            [
                'id'            => 1,
                'user_id'       => 1,
                'user_group_id' => 1,
            ],
            [
                'id'            => 2,
                'user_id'       => 2,
                'user_group_id' => 2,
            ],
        ];

        new UserUserGroup()->insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->database_tag)->dropIfExists('user_user_group');
    }
};
