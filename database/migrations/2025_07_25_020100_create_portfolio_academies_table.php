<?php

use App\Models\Portfolio\Academy;
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
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection($this->database_tag)->create('academies', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique();
            $table->string('slug', 100)->unique();
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
            $table->tinyInteger('root')->default(1);
            $table->tinyInteger('disabled')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        $data = [
            [
                'id'        => 1,
                'name'      => 'Coursera',
                'slug'      => 'coursera',
                'link'      => 'https://www.coursera.org/',
                'link_name' => 'Coursera',
                'sequence'  => 0,
                'public'    => 1,
            ],
            [
                'id'        => 2,
                'name'      => 'Gymnasium',
                'slug'      => 'gymnasium',
                'link'      => 'https://thegymnasium.com/',
                'link_name' => 'Gymnasium',
                'sequence'  => 1,
                'public'    => 1,
            ],
            [
                'id'        => 3,
                'name'      => 'KodeKloud',
                'slug'      => 'kodekloud',
                'link'      => 'https://kodekloud.com/',
                'link_name' => 'KodeKloud',
                'sequence'  => 2,
                'public'    => 1,
            ],
            [
                'id'        => 4,
                'name'      => 'MongoDB University',
                'slug'      => 'mongodb-university',
                'link'      => 'https://learn.mongodb.com/',
                'link_name' => 'MongoDB University',
                'sequence'  => 3,
                'public'    => 1,
            ],
            [
                'id'        => 5,
                'name'      => 'Scrimba',
                'slug'      => 'scrimba',
                'link'      => 'https://scrimba.com/',
                'link_name' => 'Scrimba',
                'sequence'  => 4,
                'public'    => 1,
            ],
            [
                'id'        => 6,
                'name'      => 'SitePoint',
                'slug'      => 'sitepoint',
                'link'      => 'https://www.sitepoint.com/',
                'link_name' => 'SitePoint',
                'sequence'  => 5,
                'public'    => 1,
            ],
            [
                'id'        => 7,
                'name'      => 'Udemy',
                'slug'      => 'udemy',
                'link'      => 'https://www.udemy.com/',
                'link_name' => 'Udemy',
                'sequence'  => 6,
                'public'    => 1,
            ],
            [
                'id'        => 8,
                'name'      => 'AWS Training and Certification',
                'slug'      => 'aws-training-and-certification',
                'link'      => 'https://aws.amazon.com/training/',
                'link_name' => 'AWS Training and Certification',
                'sequence'  => 7,
                'public'    => 1,
            ],
        ];

        // add timestamps
        for($i=0; $i<count($data);$i++) {
            $data[$i]['created_at'] = now();
            $data[$i]['updated_at'] = now();
        }

        Academy::insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->database_tag)->dropIfExists('academies');
    }
};
