<?php

namespace App\Console\Commands;

use App\Models\System\Backup;
use App\Models\System\Database;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use JetBrains\PhpStorm\NoReturn;
use Process;

class BackupDatabases extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:backup-databases';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    #[NoReturn] public function handle(): void
    {
        // get the databases
        $databases = new Database()->all()->pluck('database')->toArray();

        // get username and password from .env file
        $username = config('database.connections.mysql.username');
        $password = config('database.connections.mysql.password');
        if (empty($username)) {
            die('No DB_USERNAME and / or DB_PASSWORD specified in .env file');
        }

        // determine the backup directory and file
        if (!$backupDirectory = config('app.backup_directory')) {
            $backupDirectory = storage_path() . DIRECTORY_SEPARATOR . 'backups' . DIRECTORY_SEPARATOR;
        }
        $backupDirectory .= 'database' . DIRECTORY_SEPARATOR;
        $filename = 'portfolio_' . date("Ymd-His") . '.sql';
        $exportFile = $backupDirectory . $filename;

        // make sure the backup directory exists
        if (!File::exists($backupDirectory)) {
            File::makeDirectory($backupDirectory, 755, true);
        }

        if (!File::exists($backupDirectory)) {
            abort('Directory ' . $backupDirectory . ' could not be created.');
        }

        $cmd = 'mysqldump -u ' . $username;
        if (!empty($password)) {
            $cmd .= ' -p' . $password;
        }
        $cmd .= ' --databases ' . implode(' ', $databases) . ' --single-transaction --routines --triggers > ' . $exportFile . PHP_EOL;

        echo PHP_EOL . 'Backing up to ' .  $exportFile . PHP_EOL;

        $result = Process::run($cmd);

        // insert a record into the system backups table
        $backup = new Backup;
        $backup['name']        = 'all databases - ' . longDateTime(date('Y-m-d H:i:s'));
        $backup['description'] = 'Backup of all databases and tables.';
        $backup['filepath']    = $exportFile;
        $backup->save();


        if ($result->successful()) {
            echo 'Backup done';
        }
    }
}
