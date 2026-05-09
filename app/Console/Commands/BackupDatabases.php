<?php

namespace App\Console\Commands;

use App\Models\System\Database;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use JetBrains\PhpStorm\NoReturn;
use PHPUnit\Event\Runtime\PHP;
use Process;
use function Laravel\Prompts\text;

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

        $username = text('Enter the database username.');

        $password = text('Enter a password for the '. $username . ' (at least 8 characters).');

        // determine the backup directory and file
        if (!$backupDirectory = config('app.backup_directory')) {
            $backupDirectory = storage_path() . DIRECTORY_SEPARATOR . 'backups' . DIRECTORY_SEPARATOR;
        }
        $backupDirectory .= ((substr($backupDirectory, -1) != DIRECTORY_SEPARATOR) ? DIRECTORY_SEPARATOR : '') . 'database';
        $filename = 'portfolio_' . date("Ymd-His") . '.sql';
        $exportFile = $backupDirectory . $filename;

        // make sure the backup directory exists
        if (!File::exists($backupDirectory)) {
            File::makeDirectory($backupDirectory, 755, true);
        }

        if (!File::exists($backupDirectory)) {
            abort('Directory ' . $backupDirectory . ' could not be created.');
        }

        echo PHP_EOL . 'username: ' . $username . PHP_EOL;
        echo 'password: ' . str_repeat('#', strlen($password)) . PHP_EOL;
        echo 'file:     ' . $exportFile . PHP_EOL;

        text('Hit Enter to continue or Ctrl-C to cancel');

        $cmd = 'mysqldump -u ' . $username;
        if (!empty($password)) {
            $cmd .= ' -p' . $password;
        }
        $cmd .= ' --databases ' . implode(' ', $databases) . ' --single-transaction --routines --triggers > ' . $exportFile . PHP_EOL;

        echo PHP_EOL . 'Backing up to ' .  $exportFile . PHP_EOL;
        //echo PHP_EOL . $cmd . PHP_EOL;die;

        $result = Process::run($cmd);

        if ($result->successful()) {
            echo 'Backup done';
        }
    }
}
