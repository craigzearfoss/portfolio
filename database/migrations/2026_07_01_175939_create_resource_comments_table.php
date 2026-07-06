<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * @var string
     */
    protected string $database_tag = 'system_db';

    /**
     * @var string
     */
    protected string $table_name = 'resource_comments';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection($this->database_tag)->create($this->table_name, function (Blueprint $table) {
            $systemDbName = dbName('system_db');

            $table->id();
            $table->foreignId('resource_class_id')
                ->constrained($systemDbName . '.resources', 'id')
                ->onDelete('cascade');
            $table->bigInteger('resource_id');
            $table->foreignId('admin_id')
                ->nullable()
                ->constrained($systemDbName . '.admins', 'id')
                ->onDelete('cascade');
            $table->foreignId('user_id')
                ->nullable()
                ->constrained($systemDbName . '.users', 'id')
                ->onDelete('cascade');
            $table->text('text')->nullable();
            $table->text('ip_address', 20)->default(null);
            $table->tinyInteger('rating')->default(1);
            $table->integer('up_count')->default(0);
            $table->integer('down_count')->default(0);
            $table->boolean('approved')->default(false);
            $table->boolean('hidden')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->database_tag)->dropIfExists($this->table_name);
    }
};
