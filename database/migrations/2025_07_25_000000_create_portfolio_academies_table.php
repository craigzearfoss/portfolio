<?php

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
        Schema::connection('portfolio_db')->create('academies', function (Blueprint $table) {
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
                'id'       => 1,
                'name'     => 'Coursera',
                'slug'     => 'coursera',
                'link'  => null,
                'sequence' => 0,
                'public'   => 1,
            ],
            [
                'id'       => 2,
                'name'     => 'Gymnasium',
                'slug'     => 'gymnasium',
                'link'  => null,
                'sequence' => 1,
                'public'   => 1,
            ],
            [
                'id'       => 3,
                'name'     => 'KodeKloud',
                'slug'     => 'kodekloud',
                'link'  => null,
                'sequence' => 2,
                'public'   => 1,
            ],
            [
                'id'       => 4,
                'name'     => 'MongoDB University',
                'slug'     => 'mongodb-university',
                'link'  => null,
                'sequence' => 3,
                'public'   => 1,
            ],
            [
                'id'       => 5,
                'name'     => 'Scrimba',
                'slug'     => 'scrimba',
                'link'  => null,
                'sequence' => 4,
                'public'   => 1,
            ],
            [
                'id'       => 6,
                'name'     => 'SitePoint',
                'slug'     => 'sitepoint',
                'link'  => null,
                'sequence' => 5,
                'public'   => 1,
            ],
            [
                'id'       => 7,
                'name'     => 'Udemy',
                'slug'     => 'udemy',
                'link'  => null,
                'sequence' => 6,
                'public'   => 1,
            ],
            [
                'id'       => 8,
                'name'     => 'AWS Training and Certification',
                'slug'     => 'aws-training-and-certification',
                'link'  => null,
                'sequence' => 7,
                'public'   => 1,
            ],
        ];

        App\Models\Portfolio\Academy::insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('portfolio_db')->dropIfExists('academies');
    }
};
