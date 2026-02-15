<?php

use Illuminate\Database\Migrations\Migration;

/**
 * Installation Instructions
 * -------------------------
 *
 *      1. In the .env file add the database settings:
 *              PERSONAL_DB_CONNECTION=personal
 *              PERSONAL_DB_HOST=127.0.0.1
 *              PERSONAL_DB_PORT=3306
 *              PERSONAL_DB_DATABASE=personal
 *              PERSONAL_DB_USERNAME=root
 *              PERSONAL_DB_PASSWORD=
 *         You can name the database of connection anything you want.
 *
 *      2. Add the setting to the app section in the config\app.php file.
 *              'personal_db'           => env('PERSONAL_DB_DATABASE'),
 *
 *      2, Add the configuration to the config\database.php file.
 *              'personal_db' => [
 *                  'driver' => 'mysql',
 *                  'url' => env('PERSONAL_DB_URL'),
 *                  'host' => env('PERSONAL_DB_HOST', '127.0.0.1'),
 *                  'port' => env('PERSONAL_DB_PORT', '3306'),
 *                  'database' => env('PERSONAL_DB_DATABASE', 'career'),
 *                  'username' => env('PERSONAL_DB_USERNAME', 'root'),
 *                  'password' => env('PERSONAL_DB_PASSWORD', ''),
 *                  'unix_socket' => env('PERSONAL_DB_SOCKET', ''),
 *                  'charset' => env('PERSONAL_DB_CHARSET', 'utf8mb4'),
 *                  'collation' => env('PERSONAL_DB_COLLATION', 'utf8mb4_unicode_ci'),
 *                  'prefix' => '',
 *                  'prefix_indexes' => true,
 *                  'strict' => true,
 *                  'engine' => null,
 *                  'options' => extension_loaded('pdo_mysql') ? array_filter([
 *                      PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
 *                  ]) : [],
 *              ],
 *
 *      3. Add the personal route file tp the bootstrap file bootstrap\app.php.
 *              web: [
 *                      ...
 *                      __DIR__.'/../routes/personal.php',
 *                      ...
 *                  ]
 *
 *      4. Create the `personal` database.
 *
 *      5. Run artisan commands to update the configuration and clear the cache.
 *              php artisan optizime
 *              php artisan clear:config
 *              php artisan clear:cache
 */
return new class extends Migration
{
    protected string $database_tag = 'personal_db';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //@TODD: Display help messages for bad configuration or if database doesn't exist.
        $dbName = config('app.' . $this->database_tag);

        if (empty($dbName)) {
            throw new \Exception('app.'.$this->database_tag.' not defined in config\app.php file '
                . ' or PERSONAL_DB_DATABASE not defined in .env file.'
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
