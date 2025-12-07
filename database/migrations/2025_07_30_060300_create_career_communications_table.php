<?php

use App\Models\Career\Application;
use App\Models\Career\CommunicationType;
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
        Schema::connection($this->database_tag)->create('communications', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\System\Owner::class, 'owner_id');
            $table->foreignId('application_id', Application::class);
            $table->foreignId('communication_type_id', CommunicationType::class);
            $table->string('subject')->index('subject_idx');
            $table->string('to', 500)->nullable();
            $table->string('from', 500)->nullable();
            $table->date('date')->nullable();
            $table->time('time')->nullable();
            $table->text('body')->nullable();
            $table->boolean('public')->default(false);
            $table->boolean('readonly')->default(false);
            $table->boolean('root')->default(false);
            $table->boolean('disabled')->default(false);
            $table->boolean('demo')->default(false);
            $table->integer('sequence')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });

        /*
        $data = [
            'owner_id'              => null,
            'application_id'        => null,
            'communication_type_id' => null,
            'subject'               => '',
            'date'                  => '2025-10-10',
            'time'                  => '01:00:00',
            'body'                  => '',
        ];

        // add timestamps and owner_ids
        for($i=0; $i<count($data);$i++) {
            $data[$i]['created_at'] = now();
            $data[$i]['updated_at'] = now();
        }

        Communication::insert($data);
        */
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->database_tag)->dropIfExists('communications');
    }
};
