<?php

use App\Models\Admin;
use App\Models\Database;
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
        Schema::create('databases', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->string('property', 50);
            $table->string('title', 100);
            $table->string('icon', 50)->nullable();
            $table->tinyInteger('front')->default(0);
            $table->tinyInteger('user')->default(0);
            $table->tinyInteger('admin')->default(0);
            $table->integer('sequence')->default(0);
            $table->tinyInteger('public')->default(0);
            $table->tinyInteger('readonly')->default(0);
            $table->tinyInteger('root')->default(1);
            $table->tinyInteger('disabled')->default(0);
            $table->foreignIdFor( Admin::class);
            $table->timestamps();
        });


        $data = [
            [
                'id'       => 1,
                'name'     => config('app.database'),
                'property' => 'db',
                'title'    => '',
                'icon'     => 'fa-cog',
                'front'    => 0,
                'user'     => 0,
                'admin'    => 1,
                'sequence' => 4000,
                'public'   => 1,
                'disabled' => 0,
                'admin_id' => 1,
            ],
            [
                'id'       => 2,
                'name'     => 'dictionary',     //config('app.database_career'),    //TODO: using config method brings back null?
                'property' => 'dictionary_db',
                'title'    => 'Dictionary',
                'icon'     => 'fa-book',
                'front'    => 1,
                'user'     => 1,
                'admin'    => 1,
                'sequence' => 1000,
                'public'   => 1,
                'disabled' => 0,
                'admin_id' => 1,
            ],
            [
                'id'       => 3,
                'name'     => 'career',     //config('app.database_career'),    //TODO: using config method brings back null?
                'property' => 'career_db',
                'title'    => 'Career',
                'icon'     => 'fa-briefcase',
                'front'    => 0,
                'user'     => 0,
                'admin'    => 1,
                'sequence' => 2000,
                'public'   => 1,
                'disabled' => 0,
                'admin_id' => 1,
            ],
            [
                'id'       => 4,
                'name'     => 'portfolio',  //config('app.database_portfolio'), //TODO: using config method brings back null?
                'property' => 'portfolio_db',
                'title'    => 'Portfolio',
                'icon'     => 'fa-folder',
                'front'    => 1,
                'user'     => 1,
                'admin'    => 1,
                'sequence' => 3000,
                'public'   => 1,
                'disabled' => 0,
                'admin_id' => 1,
            ],
        ];
        Database::insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('databases');
    }
};
