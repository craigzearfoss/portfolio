<?php

use App\Models\System\SiteSetting;
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
        Schema::create('settings_types', function (Blueprint $table) {
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

        SiteSetting::insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings_types');
    }
};
