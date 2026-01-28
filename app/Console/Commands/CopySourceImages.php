<?php

namespace App\Console\Commands;

use App\Models\Career\Application;
use App\Models\Career\Company;
use App\Models\System\Admin;
use App\Models\System\Database;
use App\Models\System\Resource;
use Dflydev\DotAccessData\Data;
use Illuminate\Console\Command;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use function Laravel\Prompts\text;

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

    protected $imagesSrcPath = null;

    protected $imagesDestPath = null;

    protected $overwrite = false;

    protected $failedUpdates = [];

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:copy-source-images
                           {--force : Overwrite existing files}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This copies resource images from /source_files/images to /public/images. ' .
                             'The files are renamed and updated in the database(s) for enhanced security.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->overwrite = $this->option('force');

        $DS = DIRECTORY_SEPARATOR;

        // get the src and destination path for the images
        $this->imagesSrcPath = rtrim(base_path() . $DS . $this->source, $DS);
        if ($imageDir = config('app.image_dir')) {
            $this->imagesDestPath = rtrim($imageDir, $DS);
        } else {
            $this->imagesDestPath = imageDir();
        }

        // prompt to continue
        echo PHP_EOL . 'Copying images: ' . PHP_EOL;
        echo '    from: ' . $this->imagesSrcPath . PHP_EOL;
        echo '    to:   ' . $this->imagesDestPath . PHP_EOL;
        echo '*Note that this will not overwrite existing files.' . PHP_EOL;

        $dummy = text('Hit Enter to continue or Ctrl-C to cancel');

        //$this->copyResourcemages();
        $this->copyCoverLetters();
        $this->copyResumes();

        if (!empty($this->failedUpdates)) {
            echo PHP_EOL . PHP_EOL . 'The following records could not be updated:' . PHP_EOL;
            foreach ($this->failedUpdates as $failedUpdate) {
                echo '    ' . $failedUpdate . PHP_EOL;
            }
        }

        echo PHP_EOL . 'Processing complete.' . PHP_EOL;
    }

    protected function copyResourcemages()
    {
        $DS = DIRECTORY_SEPARATOR;

        foreach (scandir($this->imagesSrcPath) as $databaseSlug) {

            if ($databaseSlug == '.' || $databaseSlug == '..') continue;

            $databasePath = $this->imagesSrcPath . $DS . $databaseSlug;

            if (File::isDirectory($databasePath)) {

                echo PHP_EOL . 'Processing ' . str_replace(base_path(), '', $databasePath) . ' ...'. PHP_EOL;

                if ($databaseDefinition = Database::where('name', $databaseSlug)->first()) {

                    foreach (scandir($databasePath) as $resourceSlug) {

                        if ($resourceSlug == '.' || $resourceSlug == '..') continue;

                        $resourcePath = $databasePath . $DS . $resourceSlug;

                        if (File::isDirectory($resourcePath)) {

                            echo PHP_EOL . 'Processing ' . str_replace(base_path(), '', $resourcePath) . ' ...'
                                . PHP_EOL;

                            if ($resourceDefinition = Resource::where('name', $resourceSlug)->first()) {

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

                                            echo 'Copying files from ' . $itemPath . PHP_EOL;

                                            foreach (scandir($itemPath) as $itemSlug) {

                                                if ($itemSlug == '.' || $itemSlug == '..') continue;

                                                $srcFile = $itemPath . $DS . $itemSlug;
                                                $property = File::name($srcFile);

                                                if (File::isFile($srcFile)) {

                                                    $fileName = File::name($srcFile);
                                                    $fileExt = File::extension($srcFile);

                                                    // determine the destination file
                                                    // Note that we encode the filename for enhanced security.
                                                    $destPath = $this->imagesDestPath . $DS . $databaseSlug . $DS
                                                        . $resourceSlug . $DS . $item->id;

                                                    $destFileName = in_array($fileName, self::DEFINED_FILE_NAMES)
                                                        ? generateEncodedFilename(($item->slug ?? $item->name ?? $item->id), $fileName)
                                                        : generateEncodedFilename($fileName);;

                                                    $destFile = $destPath . $DS . $destFileName . '.' . $fileExt;

                                                    if (!File::exists($destPath)) {
                                                        File::makeDirectory($destPath, 755, true);
                                                    }

                                                    if (File::exists($destFile) && !$this->overwrite) {

                                                        // the file already exists
                                                        echo '    ' . $destFile . ' already exists.'. PHP_EOL;

                                                    } elseif ($this->overwrite || !File::exists($destFile)) {

                                                        // copy the file
                                                        echo '    ' . $itemSlug . ' => '
                                                            . str_replace(base_path(), '', $destFile) . PHP_EOL;
                                                        File::copy($srcFile, $destFile);
                                                    }

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

    protected function copyCoverLetters(): void
    {
        $DS = DIRECTORY_SEPARATOR;

        // get the src and destination path for the images
        $this->imagesSrcPath = rtrim(base_path() . $DS . $this->source, $DS);
        $this->imagesSrcPath = str_replace($DS . 'images', $DS . 'cover-letters', $this->imagesSrcPath);
        if ($imageDir = config('app.image_dir')) {
            $this->imagesDestPath = rtrim($imageDir, $DS) . $DS . 'career' . $DS . 'cover-letters';
        } else {
            $this->imagesDestPath = imageDir() . $DS . 'career' . $DS . 'cover-letters';
        }

        // prompt to continue
//        echo PHP_EOL . 'Copying images: ' . PHP_EOL;
//        echo '    from: ' . $this->imagesSrcPath . PHP_EOL;
//        echo '    to:   ' . $this->imagesDestPath . PHP_EOL;
//        echo '*Note that this will not overwrite existing files.' . PHP_EOL;

        $dummy = text('Hit Enter to continue or Ctrl-C to cancel');

        foreach (scandir($this->imagesSrcPath) as $username) {

            if ($username == '.' || $username == '..') continue;

            $usernamePath = $this->imagesSrcPath . $DS . $username;

            if (!$admin = Admin::where('username', $username)->first()) {
                echo 'Admin ' . $username . ' not found.' . PHP_EOL;
                continue;
            } else {
                $applications = Admin::select(DB::raw('applications.id AS id'),
                    DB::raw('companies.id AS company_id'), DB::raw('companies.name AS company_name'))
                    ->join(config('app.career_db').'.applications',  'applications.owner_id', 'admins.id')
                    ->join(config('app.career_db').'.companies', 'companies.id', 'applications.company_id')
                    ->where('admins.username', $username)
                    ->get();
            }
dd($applications);
            if (File::isDirectory($usernamePath)) {

                echo PHP_EOL . 'Processing ' . str_replace(base_path(), '', $usernamePath) . ' ...'. PHP_EOL;

                $applicationQuery = Admin::select(DB::raw('applications.id AS id'),
                    DB::raw('companies.id AS company_id'), DB::raw('companies.name AS company_name'))
                    ->join(config('app.career_db').'.applications',  'applications.owner_id', 'admins.id')
                    ->join(config('app.career_db').'.companies', 'companies.id', 'applications.company_id')
                    ->where('admins.username', $username);
dd($applicationQuery->get());

                if ($adminDefinition = Admin::where('username', $username)->first()) {

                    foreach (scandir($usernamePath) as $companySlug) {

                        if ($companySlug == '.' || $companySlug == '..') continue;

                        $companyPath = $usernamePath . $DS . $companySlug;

                        if (File::isDirectory($companyPath)) {

                            echo PHP_EOL . 'Processing ' . str_replace(base_path(), '', $companyPath) . ' ...'
                                . PHP_EOL;

                            if ($companyDefinition = Resource::where('name', $companySlug)->first()) {

                                try {
                                    $reflectionClass = new \ReflectionClass($companyDefinition->class);
                                } catch (\ReflectionException $e) {
                                    dd($e);
                                }
                                $instance = $reflectionClass->newInstance();

                                foreach (scandir($companyPath) as $slug) {

                                    if ($slug == '.' || $slug == '..') continue;

                                    $itemPath = $companyPath . $DS . $slug;

                                    if (File::isDirectory($itemPath)) {

                                        $query = $instance->where(
                                            in_array($companyDefinition->name, ['admin', 'user'])
                                                ? 'username'
                                                : 'slug',
                                            $slug
                                        );

                                        foreach ($query->get() as $item) {

                                            echo 'Copying files from ' . $itemPath . PHP_EOL;

                                            foreach (scandir($itemPath) as $itemSlug) {

                                                if ($itemSlug == '.' || $itemSlug == '..') continue;

                                                $srcFile = $itemPath . $DS . $itemSlug;
                                                $property = File::name($srcFile);

                                                if (File::isFile($srcFile)) {

                                                    $fileName = File::name($srcFile);
                                                    $fileExt = File::extension($srcFile);

                                                    // determine the destination file
                                                    // Note that we encode the filename for enhanced security.
                                                    $destPath = $this->imagesDestPath . $DS . $databaseSlug . $DS
                                                        . $resourceSlug . $DS . $item->id;

                                                    $destFileName = in_array($fileName, self::DEFINED_FILE_NAMES)
                                                        ? generateEncodedFilename(($item->slug ?? $item->name ?? $item->id), $fileName)
                                                        : generateEncodedFilename($fileName);;

                                                    $destFile = $destPath . $DS . $destFileName . '.' . $fileExt;

                                                    if (!File::exists($destPath)) {
                                                        File::makeDirectory($destPath, 755, true);
                                                    }

                                                    if (File::exists($destFile) && !$this->overwrite) {

                                                        // the file already exists
                                                        echo '    ' . $destFile . ' already exists.'. PHP_EOL;

                                                    } elseif ($this->overwrite || !File::exists($destFile)) {

                                                        // copy the file
                                                        echo '    ' . $itemSlug . ' => '
                                                            . str_replace(base_path(), '', $destFile) . PHP_EOL;
                                                        File::copy($srcFile, $destFile);
                                                    }

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

    protected function copyResumes(): void
    {
        $DS = DIRECTORY_SEPARATOR;

        // get the src and destination path for the images
        $this->imagesSrcPath = rtrim(base_path() . $DS . $this->source, $DS);
        $this->imagesSrcPath = str_replace($DS . 'images', $DS . 'resumes', $this->imagesSrcPath);
        if ($imageDir = config('app.image_dir')) {
            $this->imagesDestPath = rtrim($imageDir, $DS) . $DS . 'career' . $DS . 'resumes';
        } else {
            $this->imagesDestPath = imageDir() . $DS . 'career' . $DS . 'resumes';
        }

        // prompt to continue
        echo PHP_EOL . 'Copying images: ' . PHP_EOL;
        echo '    from: ' . $this->imagesSrcPath . PHP_EOL;
        echo '    to:   ' . $this->imagesDestPath . PHP_EOL;
        echo '*Note that this will not overwrite existing files.' . PHP_EOL;

        $dummy = text('Hit Enter to continue or Ctrl-C to cancel');

        foreach (scandir($this->imagesSrcPath) as $databaseSlug) {

            if ($databaseSlug == '.' || $databaseSlug == '..') continue;

            $databasePath = $this->imagesSrcPath . $DS . $databaseSlug;

            if (File::isDirectory($databasePath)) {

                echo PHP_EOL . 'Processing ' . str_replace(base_path(), '', $databasePath) . ' ...'. PHP_EOL;

                if ($databaseDefinition = Database::where('name', $databaseSlug)->first()) {

                    foreach (scandir($databasePath) as $resourceSlug) {

                        if ($resourceSlug == '.' || $resourceSlug == '..') continue;

                        $resourcePath = $databasePath . $DS . $resourceSlug;

                        if (File::isDirectory($resourcePath)) {

                            echo PHP_EOL . 'Processing ' . str_replace(base_path(), '', $resourcePath) . ' ...'
                                . PHP_EOL;

                            if ($resourceDefinition = Resource::where('name', $resourceSlug)->first()) {

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

                                            echo 'Copying files from ' . $itemPath . PHP_EOL;

                                            foreach (scandir($itemPath) as $itemSlug) {

                                                if ($itemSlug == '.' || $itemSlug == '..') continue;

                                                $srcFile = $itemPath . $DS . $itemSlug;
                                                $property = File::name($srcFile);

                                                if (File::isFile($srcFile)) {

                                                    $fileName = File::name($srcFile);
                                                    $fileExt = File::extension($srcFile);

                                                    // determine the destination file
                                                    // Note that we encode the filename for enhanced security.
                                                    $destPath = $this->imagesDestPath . $DS . $databaseSlug . $DS
                                                        . $resourceSlug . $DS . $item->id;

                                                    $destFileName = in_array($fileName, self::DEFINED_FILE_NAMES)
                                                        ? generateEncodedFilename(($item->slug ?? $item->name ?? $item->id), $fileName)
                                                        : generateEncodedFilename($fileName);;

                                                    $destFile = $destPath . $DS . $destFileName . '.' . $fileExt;

                                                    if (!File::exists($destPath)) {
                                                        File::makeDirectory($destPath, 755, true);
                                                    }

                                                    if (File::exists($destFile) && !$this->overwrite) {

                                                        // the file already exists
                                                        echo '    ' . $destFile . ' already exists.'. PHP_EOL;

                                                    } elseif ($this->overwrite || !File::exists($destFile)) {

                                                        // copy the file
                                                        echo '    ' . $itemSlug . ' => '
                                                            . str_replace(base_path(), '', $destFile) . PHP_EOL;
                                                        File::copy($srcFile, $destFile);
                                                    }

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
}
