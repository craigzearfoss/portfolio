<?php

use App\Models\ResourceDatabase;
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
        Schema::create('resource_databases', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->string('property', 50);
            $table->string('title', 100);
            $table->integer('sequence')->default(0);
            $table->tinyInteger('public')->default(0);
            $table->tinyInteger('disabled')->default(0);
        });


        $data = [
            [
                'id'       => 1,
                'name'     => config('app.database'),
                'property' => 'db',
                'title'    => '',
                'sequence' => 0,
                'public'   => 1,
                'disabled' => 0,
            ],
            [
                'id'       => 2,
                'name'     => 'portfolio',  //config('app.database_portfolio'), //TODO: using config method brings back null?
                'property' => 'portfolio_db',
                'title'    => 'Portfolio',
                'sequence' => 1,
                'public'   => 1,
                'disabled' => 0,
            ],
            [
                'id'       => 3,
                'name'     => 'career',     //config('app.database_career'),    //TODO: using config method brings back null?
                'property' => 'career_db',
                'title'    => 'Career',
                'sequence' => 2,
                'public'   => 1,
                'disabled' => 0,
            ],
        ];
        ResourceDatabase::insert($data);

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resource_databases');
    }
};
