<?php

use App\Models\Portfolio\Certification;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * The tag used to identify the portfolio database.
     *
     * @var string
     */
    protected $database_tag = 'portfolio_db';

    /**
     * The id of the admin who owns the portfolio certifications resource.
     *
     * @var int
     */
    protected $ownerId = 2;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection($this->database_tag)->create('certifications', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Owner::class, 'owner_id');
            $table->string('name');
            $table->string('slug');
            $table->tinyInteger('featured')->default(0);
            $table->string('summary')->nullable();
            $table->string('organization')->nullable();
            $table->foreignIdFor( \App\Models\Portfolio\Academy::class)->default(1);
            $table->year('year')->nullable();
            $table->date('received')->nullable();
            $table->date('expiration')->nullable();
            $table->string('certificate_url', 500)->nullable();
            $table->text('notes')->nullable();
            $table->string('link', 500)->nullable();
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
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['owner_id', 'name'], 'owner_id_name_unique');
            $table->unique(['owner_id', 'slug'], 'owner_id_slug_unique');
        });

        $data = [
            [
                'id'              => 1,
                'name'            => 'Google Cybersecurity',
                'slug'            => 'google-cybersecurity',
                'featured'        => 1,
                'summary'         => null,
                'organization'    => 'Google',
                'academy_id'      => 3,
                'year'            => 2023,
                'received'        => '2023-07-11',
                'certificate_url' => 'images/admin/portfolio/2/certificate/HGL8U7MSRWFL.png',
                'link'            => 'https://coursera.org/verify/professional-cert/HGL8U7MSRWFL',
                'link_name'       => 'Coursera verification',
                'description'     => 'Includes the following courses:<ul><li>Foundations of Cybersecurity</li><li>Play It Safe: Manage Security Risks</li><li>Connect and Protect: Networks and Network Security</li><li>Tools of the Trade: Linux and SQL</li><li>Assets, Threats, Vulnerabilities</li><li>Sound the Alarm: Detection and Response</li><li>Automate Cybersecurity Tasks with Python</li><li>Put It to Work: Prepare for Cybersecurity Jobs</li></ul>',
            ]
        ];

        // add timestamps and owner_ids
        for($i=0; $i<count($data);$i++) {
            $data[$i]['created_at'] = now();
            $data[$i]['updated_at'] = now();
            $data[$i]['owner_id']   = $this->ownerId;
        }

        Certification::insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->database_tag)->dropIfExists('certifications');
    }
};
