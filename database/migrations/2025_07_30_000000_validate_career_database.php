<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    protected string $database_tag = 'career_db';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $dbName = dbName($this->database_tag);

        if (empty($dbName)) {
            abort(500, 'app.'.$this->database_tag.' not defined in config\app.php file '
                . ' or CAREER_DB_DATABASE not defined in .env file.');
        }

        if (empty(DB::select("SHOW DATABASES LIKE '$dbName'"))) {
            abort("Database `$dbName` does not exist.");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
