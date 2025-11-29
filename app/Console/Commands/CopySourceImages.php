<?php

namespace App\Console\Commands;

use App\Models\System\Admin;
use App\Models\System\Database;
use App\Models\System\Resource;
use Dflydev\DotAccessData\Data;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class CopySourceImages extends Command
{
    const DEFINED_FILE_NAMES = [
        'certificate_url',
        'image',
        'image_url',
        'logo',
        'logo_small',
        'photo_url',
        'profile',
        'thumbnail',
    ];

    protected $source = 'source_files' . DIRECTORY_SEPARATOR . 'images';

    protected $destination = 'public' . DIRECTORY_SEPARATOR . 'images';

    protected $overwrite = false;

    protected $failedUpdates = [];

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:copy-source-images {--force}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This copies resource images from /source_files/images to /public/images.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->overwrite = $this->option('force');

        $DS = DIRECTORY_SEPARATOR;

        $imagesPath = base_path() . $DS . $this->source;
        foreach (scandir($imagesPath) as $databaseName) {

            if ($databaseName == '.' || $databaseName == '..') continue;

            $databasePath = $imagesPath . $DS . $databaseName;

            if (File::isDirectory($databasePath)) {

                echo PHP_EOL . 'Processing ' . str_replace(base_path(), '', $databasePath) . ' ...'. PHP_EOL;

                if ($databaseDefinition = Database::where('name', $databaseName)->first()) {

                    foreach (scandir($databasePath) as $resourceName) {

                        if ($resourceName == '.' || $resourceName == '..') continue;

                        $resourcePath = $databasePath . $DS . $resourceName;

                        if (File::isDirectory($resourcePath)) {

                            echo PHP_EOL . 'Processing ' . str_replace(base_path(), '', $resourcePath) . ' ...'
                                . PHP_EOL;

                            if ($resourceDefinition = Resource::where('name', $resourceName)->first()) {

                                try {
                                    $reflectionClass = new \ReflectionClass($resourceDefinition->class);
                                } catch (\ReflectionException $e) {
                                    dd($e);
                                }
                                $instance = $reflectionClass->newInstance();

                                foreach (scandir($resourcePath) as $slug) {

                                    if ($slug == '.' || $slug == '..') continue;

                                    $itemPath = $resourcePath . $DS . $slug;

                                    if (File::isDirectory($itemPath)) {

                                        $query = $instance->where(
                                            in_array($resourceDefinition->name, ['admin', 'user'])
                                                ? 'username'
                                                : 'slug',
                                            $slug
                                        );

                                        foreach ($query->get() as $item) {

                                            echo 'Copying files from '
                                                . str_replace(base_path(), '', $itemPath)
                                                . ' ...'. PHP_EOL;

                                            foreach (scandir($itemPath) as $itemName) {

                                                if ($itemName == '.' || $itemName == '..') continue;

                                                $srcFile = $itemPath . $DS . $itemName;
                                                $property = File::name($srcFile);

                                                if (File::isFile($srcFile)) {

                                                    $fileName = File::name($srcFile);
                                                    $fileExt = File::extension($srcFile);

                                                    // determine the destination file
                                                    // base64 encode known file names
                                                    $destPath = base_path() . $DS . $this->destination . $DS
                                                        . $databaseName . $DS . $resourceName . $DS . $item->id;
                                                    $destFileName = in_array($fileName, self::DEFINED_FILE_NAMES)
                                                        ? rtrim(str_replace(['+', '/'], ['-', '_'], base64_encode($slug . $itemName)), '=')
                                                        : $fileName;
                                                    $destFile = $destPath . $DS . $destFileName . '.' . $fileExt;

                                                    if (!File::exists($destPath)) {
                                                        File::makeDirectory($destPath, 755, true);
                                                    }

                                                    if ($this->overwrite || !File::exists($destFile)) {

                                                        // copy the file
                                                        echo '    ' . $itemName . ' => '
                                                            . str_replace(base_path(), '', $destFile) . PHP_EOL;
                                                        File::copy($srcFile, $destFile);

                                                        // update the resource in the database
                                                        try {

                                                            $relativeDestPath = str_replace(
                                                                base_path() .$DS . 'public',
                                                                '',
                                                                $destFile
                                                            );
                                                            $urlPath = str_replace(DIRECTORY_SEPARATOR, '/',  $relativeDestPath);

                                                            $item->{$property} = $urlPath;
                                                            $item->save();

                                                        } catch (\Throwable $e) {
                                                            $this->failedUpdates[] = $item->id
                                                                . ' [' . $property . '] => ' . $relativeDestPath;
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        if (!empty($this->failedUpdates)) {
            echo PHP_EOL . PHP_EOL . 'The following records could not be updated:' . PHP_EOL;
            foreach ($this->failedUpdates as $failedUpdate) {
                echo '    ' . $failedUpdate . PHP_EOL;
            }
        }

        echo PHP_EOL . 'Processing complete.' . PHP_EOL;
    }
}
