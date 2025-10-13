<?php

use App\Models\System\SiteSetting;
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
        Schema::connection($this->database_tag)->create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->foreignIdFor( \App\Models\System\SettingType::class);
            $table->string('value')->nullable();
            $table->timestamps();
        });

        /*
        $data = [
            [
                'id'              => 1,
                'name'            => '',
                'setting_type_id' =>  5,
                'value'           => null,
            ],
        ];

        SiteSetting::insert($data);
        */
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->database_tag)->dropIfExists('site_settings');
    }
};
