<?php

use App\Models\Career\CommunicationType ;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * @var string
     */
    protected string $database_tag = 'career_db';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection($this->database_tag)->create('communication_types', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->unique();
            $table->integer('sequence');
        });

        $data = [
            [
                'id'       => 1,
                'name'     => 'Other',
                'sequence' => 6,
            ],
            [
                'id'       => 2,
                'name'     => 'Conversation',
                'sequence' => 0,
            ],
            [
                'id'       => 3,
                'name'     => 'Email',
                'sequence' => 1,
            ],
            [
                'id'       => 4,
                'name'     => 'Fax',
                'sequence' => 2,
            ],
            [
                'id'       => 5,
                'name'     => 'Letter',
                'sequence' => 3,
            ],
            [
                'id'       => 6,
                'name'     => 'Phone Call',
                'sequence' => 4,
            ],
            [
                'id'       => 7,
                'name'     => 'Text',
                'sequence' => 5,
            ],
        ];

        new CommunicationType()->insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->database_tag)->dropIfExists('communication_types');
    }
};
