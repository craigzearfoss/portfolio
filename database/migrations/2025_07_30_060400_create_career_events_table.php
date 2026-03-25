<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * @var string
     */
    protected string $database_tag = 'career_db';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection($this->database_tag)->create('events', function (Blueprint $table) {

            $systemDbName = Schema::connection('system_db')->getCurrentSchemaName();

            $table->id();
            $table->foreignId('owner_id')
                ->constrained($systemDbName . '.admins', 'id')
                ->onDelete('cascade');
            $table->foreignId('application_id')
                ->constrained('applications', 'id')
                ->onDelete('cascade');
            $table->string('name')->index('name_idx');
            $table->date('date')->nullable()->index('date_idx');
            $table->time('time')->nullable();
            $table->string('location')->nullable()->index('location_idx');
            $table->string('attendees', 500)->nullable()->index('attendees_idx');
            $table->text('description')->nullable();
            $table->boolean('is_public')->default(false);
            $table->boolean('is_readonly')->default(false);
            $table->boolean('is_root')->default(false);
            $table->boolean('is_disabled')->default(false);
            $table->boolean('is_demo')->default(false);
            $table->integer('sequence')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        /*
        $data = [
            'owner_id'       => null,
            'application_id' => null,
            'name'           => '',
            'date'           => '2025-10-10',
            'time'           => '01:00:00',
            'location'       => '',
            'description'    => '',
        ];

        // add timestamps
        for($i=0; $i<count($data);$i++) {
            $data[$i]['created_at'] = now();
            $data[$i]['updated_at'] = now();
        }

        Event::insert($data);
        */
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->database_tag)->dropIfExists('events');
    }
};
