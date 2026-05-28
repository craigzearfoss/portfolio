<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class BackupImageFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:backup-image-files';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $srcDirectory = public_path() . DIRECTORY_SEPARATOR . 'portfolio' . DIRECTORY_SEPARATOR . 'images';

        // determine the backup directory
        if (!$backupDirectoryRoot = config('app.backup_directory')) {
            $backupDirectoryRoot = storage_path() . DIRECTORY_SEPARATOR . 'backups';
        }
        $backupDirectoryRoot .= DIRECTORY_SEPARATOR . 'files';;
        $backupDirectory = $backupDirectoryRoot . DIRECTORY_SEPARATOR . 'images_' . date("Ymd-His");

        echo 'Copying files' . PHP_EOL;
        echo 'From: ' . $srcDirectory . PHP_EOL;
        echo 'To:   ' . $backupDirectory . PHP_EOL;

        // make sure the backup directory exists
        if (!File::exists($backupDirectory)) {
            File::makeDirectory($backupDirectory, 755, true);
        }

        File::copyDirectory($srcDirectory, $backupDirectory);

        echo 'Backup done';
    }
}
