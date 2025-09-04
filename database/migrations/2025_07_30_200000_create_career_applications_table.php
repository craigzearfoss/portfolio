<?php

use App\Models\Career\Resume;
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
        Schema::connection('career_db')->create('applications', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor( \App\Models\Career\Company::class);
            $table->foreignIdFor( \App\Models\Career\CoverLetter::class);
            $table->foreignIdFor( \App\Models\Career\Resume::class);
            $table->string('role');
            $table->tinyInteger('rating')->default(0);
            $table->tinyInteger('active')->default(1);
            $table->date('post_date')->nullable();
            $table->date('apply_date')->nullable();
            $table->date('close_date')->nullable();
            $table->integer('compensation')->default(0);
            $table->string('compensation_unit', 20)->nullable();
            $table->string('duration',100)->nullable();
            $table->tinyInteger('type')->default(0)->comment('0-permanent,1-contract,2-contract-to-hire,3-project,4-temporary');
            $table->tinyInteger('office')->default(0)->comment('0-onsite,1-remote,2-hybrid');
            $table->string('city')->nullable();
            $table->string('state', 20)->nullable();
            $table->integer('bonus')->default(0);
            $table->tinyInteger('w2')->default(0);
            $table->tinyInteger('relocation')->default(0);
            $table->tinyInteger('benefits')->default(0);
            $table->tinyInteger('vacation')->default(0);
            $table->tinyInteger('health')->default(0);
            $table->string('job_board_id')->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('phone_label', 255)->nullable();
            $table->string('alt_phone', 20)->nullable();
            $table->string('alt_phone_label', 255)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('email_label', 255)->nullable();
            $table->string('alt_email', 255)->nullable();
            $table->string('alt_email_label', 255)->nullable();
            $table->string('link')->nullable();
            $table->string('link_name')->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->string('image_credit')->nullable();
            $table->string('image_source')->nullable();
            $table->string('thumbnail')->nullable();
            $table->integer('sequence')->default(0);
            $table->tinyInteger('public')->default(0);
            $table->integer('readonly')->default(0);
            $table->integer('root')->default(0);
            $table->tinyInteger('disabled')->default(0);
            $table->foreignIdFor( \App\Models\Admin::class);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('career_db')->dropIfExists('applications');
    }
};
