<?php

use App\Models\Country;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $database_tag = 'core_db';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //@TODD: Display help messages for bad configuration or if database doesn't exist.
        $dbName = config('app.' . $this->database_tag);

        if (empty($dbName)) {
            throw new \Exception('app.'.$this->database_tag.' not defined in config\app.php file '
                . ' or CORE_DB_DATABASE not defined in .env file.'
            );
        }

        if (empty(DB::select("SHOW DATABASES LIKE '{$dbName}'"))) {
            throw new \Exception("Database `{$dbName}` does not exist.");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
