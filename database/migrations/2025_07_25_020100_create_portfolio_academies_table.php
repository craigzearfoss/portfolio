<?php

use App\Models\Portfolio\Academy;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * @var string
     */
    protected string $database_tag = 'portfolio_db';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection($this->database_tag)->create('academies', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique();
            $table->string('slug', 100)->unique();
            $table->string('link', 500)->nullable();
            $table->string('link_name')->nullable();
            $table->text('description')->nullable();
            $table->string('image', 500)->nullable();
            $table->string('image_credit')->nullable();
            $table->string('image_source')->nullable();
            $table->string('thumbnail', 500)->nullable();
            $table->string('logo', 500)->nullable();
            $table->string('logo_small', 500)->nullable();
            $table->boolean('public')->default(true);
            $table->boolean('readonly')->default(false);
            $table->boolean('root')->default(true);
            $table->boolean('disabled')->default(false);
            $table->boolean('demo')->default(false);
            $table->integer('sequence')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });

        $data = [
            [
                'id'        => 1,
                'name'      => 'other',
                'slug'      => 'other',
                'link'      => null,
                'link_name' => null,
                'sequence'  => 0,
            ],
            [
                'id'        => 2,
                'name'      => 'Coursera',
                'slug'      => 'coursera',
                'link'      => 'https://www.coursera.org/',
                'link_name' => 'Coursera',
                'sequence'  => 0,
            ],
            [
                'id'        => 3,
                'name'      => 'Gymnasium',
                'slug'      => 'gymnasium',
                'link'      => 'https://thegymnasium.com/',
                'link_name' => 'Gymnasium',
                'sequence'  => 1,
            ],
            [
                'id'        => 4,
                'name'      => 'KodeKloud',
                'slug'      => 'kodekloud',
                'link'      => 'https://kodekloud.com/',
                'link_name' => 'KodeKloud',
                'sequence'  => 2,
            ],
            [
                'id'        => 5,
                'name'      => 'MongoDB University',
                'slug'      => 'mongodb-university',
                'link'      => 'https://learn.mongodb.com/',
                'link_name' => 'MongoDB University',
                'sequence'  => 3,
            ],
            [
                'id'        => 6,
                'name'      => 'Scrimba',
                'slug'      => 'scrimba',
                'link'      => 'https://scrimba.com/',
                'link_name' => 'Scrimba',
                'sequence'  => 4,
            ],
            [
                'id'        => 7,
                'name'      => 'SitePoint',
                'slug'      => 'sitepoint',
                'link'      => 'https://www.sitepoint.com/',
                'link_name' => 'SitePoint',
                'sequence'  => 5,
            ],
            [
                'id'        => 8,
                'name'      => 'Udemy',
                'slug'      => 'udemy',
                'link'      => 'https://www.udemy.com/',
                'link_name' => 'Udemy',
                'sequence'  => 6,
            ],
            [
                'id'        => 9,
                'name'      => 'AWS Training and Certificate',
                'slug'      => 'aws-training-and-certificate',
                'link'      => 'https://aws.amazon.com/training/',
                'link_name' => 'AWS Training and Certificate',
                'sequence'  => 7,
            ],
        ];

        // add timestamps
        for($i=0; $i<count($data);$i++) {
            $data[$i]['public'] = 1;
            $data[$i]['root'] = 1;
            $data[$i]['created_at'] = now();
            $data[$i]['updated_at'] = now();
        }

        new Academy()->insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->database_tag)->dropIfExists('academies');
    }
};
