<?php

namespace App\Console\Commands;

use App\Models\Career\Application;
use App\Models\Career\Company;
use App\Models\Career\CoverLetter;
use App\Models\Career\Resume;
use App\Models\Scopes\AdminPublicScope;
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
        'logo',
        'logo_small',
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
    public function handle(): void
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

        $this->copyResourcemages();
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

                if ($databaseDefinition = new Database()->wher('name', $databaseSlug)->first()) {

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
                                                        : generateEncodedFilename($fileName);

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
            $this->imagesDestPath = rtrim($imageDir, $DS) . $DS . 'career' . $DS . 'cover-letter';
        } else {
            $this->imagesDestPath = imageDir() . $DS . 'career' . $DS . 'cover-letter';
        }

        foreach (scandir($this->imagesSrcPath) as $username) {

            if ($username == '.' || $username == '..') continue;

            $usernamePath = $this->imagesSrcPath . $DS . $username;

            if (!$admin = Admin::where('username', $username)->first()) {
                echo 'Admin ' . $username . ' not found.' . PHP_EOL;
                continue;
            }

            if (File::isDirectory($usernamePath)) {

                echo PHP_EOL . 'Processing ' . str_replace(base_path(), '', $usernamePath) . ' ...' . PHP_EOL;

                $coverLetterQuery = CoverLetter::withoutGlobalScope(AdminPublicScope::class)
                    ->select(['id', 'slug'])
                    ->where('cover_letters.owner_id', $admin->id);

                $coverLetters = [];
                foreach ($coverLetterQuery->get() as $coverLetter) {
                    if (!empty($coverLetter->slug)) {
                        $coverLetters[$coverLetter->slug] = $coverLetter->id;
                    }
                }

                foreach (scandir($usernamePath) as $coverLetterFile) {

                    if ($coverLetterFile == '.' || $coverLetterFile == '..') continue;

                    $coverLetterPath = $usernamePath . $DS . $coverLetterFile;

                    if (File::isFile($coverLetterPath)) {

                        $fileName = File::name($coverLetterPath);
                        $fileExt = File::extension($coverLetterPath);

                        if (!array_key_exists($fileName, $coverLetters)) {
                            echo '    ' . $username . $DS . $coverLetterFile . ' not found in database **' . PHP_EOL;
                            continue;
                        }

                        $coverLetterId = $coverLetters[$fileName];

                        // determine the destination file
                        // Note that we encode the filename for enhanced security.
                        $destPath = $this->imagesDestPath . $DS . $coverLetterId;
                        $destFileName = generateEncodedFilename($coverLetterId, $coverLetterFile);
                        $destFile = $destPath . $DS . $destFileName . '.' . $fileExt;

                        if (!File::exists($destPath)) {
                            File::makeDirectory($destPath, 755, true);
                        }

                        if (File::exists($destFile) && !$this->overwrite) {

                            // the file already exists
                            echo '    ' . $username . $DS . $coverLetterFile . ' already exists.' . PHP_EOL;

                        } elseif ($this->overwrite || !File::exists($destFile)) {

                            // copy the file
                            echo '    ' . $coverLetterFile . ' => '
                                . str_replace(base_path(), '', $destFile) . PHP_EOL;

                            File::copy($coverLetterPath, $destFile);
                        }

                        // update the resource in the database
                        try {

                            $relativeDestPath = str_replace(
                                base_path() .$DS . 'public',
                                '',
                                $destFile
                            );
                            $urlPath = str_replace(DIRECTORY_SEPARATOR, '/',  $relativeDestPath);

                            $coverLetter = CoverLetter::withoutGlobalScope(AdminPublicScope::class)
                                ->find($coverLetterId);
                            $coverLetter->filepath = $relativeDestPath;
                            $coverLetter->save();

                        } catch (\Throwable $e) {
                            $this->failedUpdates[] = $coverLetterId . ' [filepath] => ' . $relativeDestPath;
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
            $this->imagesDestPath = rtrim($imageDir, $DS) . $DS . 'career' . $DS . 'resume';
        } else {
            $this->imagesDestPath = imageDir() . $DS . 'career' . $DS . 'resume';
        }

        foreach (scandir($this->imagesSrcPath) as $username) {

            if ($username == '.' || $username == '..') continue;

            $usernamePath = $this->imagesSrcPath . $DS . $username;

            if (!$admin = Admin::where('username', $username)->first()) {
                echo 'Admin ' . $username . ' not found.' . PHP_EOL;
                continue;
            }

            if (File::isDirectory($usernamePath)) {

                echo PHP_EOL . 'Processing ' . str_replace(base_path(), '', $usernamePath) . ' ...' . PHP_EOL;

                $resumeQuery = Resume::withoutGlobalScope(AdminPublicScope::class)
                    ->select(['id', 'slug'])
                    ->where('resumes.owner_id', $admin->id);

                $resumes = [];
                foreach ($resumeQuery->get() as $resume) {
                    if (!empty($resume->slug)) {
                        $resumes[$resume->slug] = $resume->id;
                    }
                }

                foreach (scandir($usernamePath) as $resumeFile) {

                    if ($resumeFile == '.' || $resumeFile == '..') continue;

                    $resumePath = $usernamePath . $DS . $resumeFile;

                    if (File::isFile($resumePath)) {

                        $fileName = File::name($resumePath);
                        $fileExt = File::extension($resumePath);

                        if (!array_key_exists($fileName, $resumes)) {
                            echo '    *' . $username . $DS . $resumeFile . ' not found in database.' . PHP_EOL;
                            continue;
                        }

                        $resumeId = $resumes[$fileName];

                        // determine the destination file
                        // Note that we encode the filename for enhanced security.
                        $destPath = $this->imagesDestPath . $DS . $resumeId;
                        $destFileName = generateEncodedFilename($resumeId, $resumeFile);
                        $destFile = $destPath . $DS . $destFileName . '.' . $fileExt;

                        if (!File::exists($destPath)) {
                            File::makeDirectory($destPath, 755, true);
                        }

                        if (File::exists($destFile) && !$this->overwrite) {

                            // the file already exists
                            echo '    +' . $username . $DS . $resumeFile . ' already exists.' . PHP_EOL;

                        } elseif ($this->overwrite || !File::exists($destFile)) {

                            // copy the file
                            echo '    ' . $username . $DS . $resumeFile . ' => '
                                . str_replace(base_path(), '', $destFile) . PHP_EOL;

                            File::copy($resumePath, $destFile);
                        }

                        // update the resource in the database
                        try {

                            $relativeDestPath = str_replace(
                                base_path() .$DS . 'public',
                                '',
                                $destFile
                            );
                            $resume = Resume::withoutGlobalScope(AdminPublicScope::class)
                                ->find($resumeId);
//dd([$resume, $fileExt, $relativeDestPath]);
                            if ($fileExt == 'pdf') {
                                $resume->pdf_filepath = $relativeDestPath;
                            } else {
                                $resume->doc_filepath = $relativeDestPath;
                            }
                            $resume->save();

                        } catch (\Throwable $e) {
                            $this->failedUpdates[] = $resumeId . ' [filepath] => ' . $relativeDestPath;
                        }
                    }
                }
            }
        }
    }
}
