<?php

use App\Models\System\AdminEmail;
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
        Schema::connection($this->database_tag)->create('admin_emails', function (Blueprint $table) {
            $table->id();
            $table->foreignId('owner_id')
                ->constrained('admins', 'id')
                ->onDelete('cascade');
            $table->string('email', 255);
            $table->string('label', 100)->nullable();
            $table->text('description')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('public')->default(false);
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

            new AdminEmail()->insert($data);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->database_tag)->dropIfExists('admin_emails');
    }
};
