<?php

use App\Models\Portfolio\Certification;
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
        Schema::connection('portfolio_db')->create('certifications', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->tinyInteger('professional')->default(1);
            $table->tinyInteger('personal')->default(0);
            $table->string('organization')->nullable();
            $table->foreignIdFor( \App\Models\Portfolio\Academy::class)->default(1);
            $table->year('year')->nullable();
            $table->date('received')->nullable();
            $table->date('expiration')->nullable();
            $table->string('certificate_url')->nullable();
            $table->string('link')->nullable();
            $table->string('link_name')->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->string('image_credit')->nullable();
            $table->string('image_source')->nullable();
            $table->string('thumbnail')->nullable();
            $table->integer('sequence')->default(0);
            $table->tinyInteger('public')->default(1);
            $table->tinyInteger('readonly')->default(0);
            $table->tinyInteger('root')->default(0);
            $table->tinyInteger('disabled')->default(0);
            $table->foreignIdFor(\App\Models\Admin::class);
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['admin_id', 'name'], 'admin_id_name_unique');
            $table->unique(['admin_id', 'slug'], 'admin_id_slug_unique');
        });

        $data = [
            [
                'id'              => 1,
                'name'            => 'Google Cybersecurity',
                'slug'            => 'google-cybersecurity',
                'professional'    => '1',
                'organization'    => 'Google',
                'academy_id'      => 8,
                'year'            => 2023,
                'received'        => '2023-07-11',
                'certificate_url' => 'images/admin/portfolio/2/certificate/HGL8U7MSRWFL.png',
                'link'            => 'https://coursera.org/verify/professional-cert/HGL8U7MSRWFL',
                'link_name'       => 'Coursera verification',
                'description'     => 'Includes the following courses:\\n1. Foundations of Cybersecurity\\n2. Play It Safe: Manage Security Risks\\n3. Connect and Protect: Networks and Network Security\\n4. Tools of the Trade: Linux and SQL\\n5. Assets, Threats, Vulnerabilities\\n6. Sound the Alarm: Detection and Response\\n7. Automate Cybersecurity Tasks with Python\\n8. Put It to Work: Prepare for Cybersecurity Jobs',
                'admin_id'        => 2,
            ]
        ];

        Certification::insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('portfolio_db')->dropIfExists('certifications');
    }
};
