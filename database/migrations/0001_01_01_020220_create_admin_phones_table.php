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
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection($this->database_tag)->create('admin_phones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('owner_id')
                ->constrained('admins', 'id')
                ->onDelete('cascade');
            $table->string('phone', 20)->index('phone_idx');
            $table->string('label', 100)->nullable()->index('label_idx');
            $table->text('description')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('is_public')->default(false);
            $table->boolean('is_readonly')->default(false);
            $table->boolean('is_root')->default(true);
            $table->boolean('is_disabled')->default(false);
            $table->boolean('is_demo')->default(false);
            $table->integer('sequence')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        $data = [];

        if (!empty($data)) {
            // add timestamps
            for($i=0; $i<count($data);$i++) {
                $data[$i]['created_at'] = now();
                $data[$i]['updated_at'] = now();
            }

            DB::connection($this->database_tag)->table('admin_phones')->insert($data);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->database_tag)->dropIfExists('admin_phones');
    }
};
