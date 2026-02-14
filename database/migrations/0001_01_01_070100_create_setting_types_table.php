<?php

use App\Models\System\SettingType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * The tag used to identify the system database.
     *
     * @var string
     */
    protected $database_tag = 'system_db';

    /**
     * The id of the admin who owns the system resources.
     * The admin must have root permissions.
     *
     * @var int
     */
    protected $ownerId = 1;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection($this->database_tag)->create('setting_types', function (Blueprint $table) {
            $table->id();
            $table->string('name', 20);
            $table->text('description')->nullable();
        });

        $data = [
            [ 'id' => 1, 'name' => 'array'  ],
            [ 'id' => 2, 'name' => 'bool'   ],
            [ 'id' => 3, 'name' => 'float'  ],
            [ 'id' => 4, 'name' => 'int'    ],
            [ 'id' => 5, 'name' => 'string' ],
        ];

        new SettingType()->insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->database_tag)->dropIfExists('setting_types');
    }
};
