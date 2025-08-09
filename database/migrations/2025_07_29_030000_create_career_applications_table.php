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
            $table->foreignIdFor( \App\Models\Admin::class)->default(1);
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
            $table->tinyInteger('type')->default(0)->comment('0-permanent,1-contract,2-contract-to-hire,3-project');
            $table->tinyInteger('office')->default(0)->comment('0-onsite,1-remote,2-hybrid');
            $table->string('city')->nullable();
            $table->string('state', 20)->nullable();
            $table->integer('bonus')->default(0);
            $table->tinyInteger('w2')->default(0);
            $table->tinyInteger('relocation')->default(0);
            $table->tinyInteger('benefits')->default(0);
            $table->tinyInteger('vacation')->default(0);
            $table->tinyInteger('health')->default(0);
            $table->string('source')->nullable();
            $table->string('link')->nullable();
            $table->string('contacts')->nullable();
            $table->string('phones')->nullable();
            $table->string('emails')->nullable();
            $table->string('website')->nullable();
            $table->text('description')->nullable();
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
