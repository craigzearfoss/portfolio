<?php

namespace App\Services;

use App\Models\System\Admin;
use App\Models\System\AdminResource;
use App\Models\System\Owner;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use ReflectionClass;
use ReflectionException;
use Str;

class ResourceFileService {

    /**
     * Array of valid upload types.
     */
    const array UPLOAD_TYPES = [
        //'audio',
        'document',
        'image',
        //'video',
    ];

    /**
     * Array of valid column names for audio files.
     */
    const array AUDIO_COLUMNS = [
    ];

    /**
     * Array of valid column names for document files.
     */
    const array DOCUMENT_COLUMNS = [
        'doc_filepath',
        'filepath',
        'pdf_filepath',
    ];

    /**
     * Array of valid column names for image files.
     */
    const array IMAGE_COLUMNS = [
        'certificate_url',
        'icon',
        'image',
        'logo',
        'logo_small',
        'thumbnail',
    ];

    /**
     * Array of valid column names for video files.
     */
    const array VIDEO_COLUMNS = [
    ];


    /**
     * Is
     *
     * @var bool
     */
    public bool $fileUploaded = false;

    public bool $requestValidated = false;

    public bool $fileMoved = false;

    public bool $uploadVerified = false;

    public bool $databaseUpdated = false;

    public bool $uploadCompleted = false;

    protected bool $uploadsEnabled = false;

    protected int $maxFileSize = 2048;

    protected string|null $uploadType = null;

    protected array $validColumns = [];

    protected array $acceptedFileExtensions = [];
    protected int|null $resourceTypeId = null;

    protected int|null $resourceId = null;

    protected Request|null $request = null;

    protected string|null $resourceTypeName = null;

    protected Object|null $adminResource = null;

    protected Object|null $reflectionClass = null;

    protected Object|null $resource = null;

    protected string|null $column = null;

    protected Admin|Owner|null $admin = null;
    protected string|null $rootPath = null;

    protected string|null $relativePath = null;

    protected string|null $destinationPath = null;

    protected string|null $filename = null;

    protected array $errors = [];

    /**
     * @param string|null $rootPath
     */
    public function __construct(string|null $rootPath = null)
    {
        if (!empty($rootPath)) {
            $this->rootPath = $rootPath;
        } else {
            $this->rootPath = public_path();
        }

        $this->uploadsEnabled = config('app.upload_enabled');

        $maxFileSize = config('app.max_file_size');
        if (!empty($maxFileSize)) {
            $this->maxFileSize = $maxFileSize;
        }
    }

    /**
     * @param Request $request
     * @param Admin|Authenticatable $admin
     * @return bool|string
     * @throws ReflectionException
     */
    public function validateUpload(Request $request, Admin|Authenticatable $admin): bool|string
    {
        $this->request = $request;
        $this->admin = $admin;

        // are uploads enabled?
        if (!$this->uploadsEnabled) {
            return $this->addError('Uploads are disabled.');
        }

        // verify resource anc permissions to upload file
        if (!$this->resourceTypeId = intval($this->request->input('resource_type_id'))) {
            return $this->addError('No resource_type_id specified.');
        }
        if (!$this->resourceId = intval($this->request->input('resource_id'))) {
            return $this->addError('No resource_id specified.');
        }

        if (!$this->adminResource = new AdminResource()->newQuery()->where('owner_id', $this->admin['id'])
            ->where('resource_id', $this->resourceTypeId)->first()
        ) {
            return $this->addError( 'resource_type_id ' . $this->resourceTypeId .
                ' does not exist or you do mot have permission to access it.');
        }

        $this->resourceTypeName = substr($this->adminResource->class, strrpos($this->adminResource->class, '\\') + 1);

        try {
            $this->reflectionClass = new ReflectionClass($this->adminResource->class);
        } catch (ReflectionException $e) {
            return $this->addError($this->resourceTypeName . ' object could not be instantiated. ' . $e->getMessage());
        }

        if (!$this->resource = $this->reflectionClass->newInstance()->newQuery()->find($this->resourceId)) {
            return $this->addError($this->resourceTypeName . ' ' . $this->resourceId . ' not found.');
        } elseif (($this->resource->owner_id != $this->admin['id']) && !$this->admin['is_root']) {
            return $this->addError('You do not have permission to upload files to ' .
                $this->resourceTypeName . ' ' . $this->resourceId . '.');
        }

        // get maximum file size
        $this->maxFileSize = config('app.upload_max_filesize');

        // validate the file upload type
        if (!$this->uploadType = $this->request->input('upload_type')) {
            return $this->addError('No upload_type specified.');
        } elseif (!in_array($this->uploadType, self::UPLOAD_TYPES)) {
            return $this->addError('Invalid upload_type `specified. Valid upload_types are ' .
                implode(', ', self::UPLOAD_TYPES) . '.');
        }

        // validate column
        if (!$this->column = $this->request->input('column')) {
            return $this->addError('No column specified.');
        }
        $this->validColumns = match ($this->uploadType) {
            'audio' => self::AUDIO_COLUMNS,
            'document' => self::DOCUMENT_COLUMNS,
            'image' => self::IMAGE_COLUMNS,
            'video' => self::VIDEO_COLUMNS,
            default => [],
        };

        if (!in_array($this->column, $this->validColumns)) {
            return $this->addError('Invalid column `' . $this->column . '` specified.');
        } elseif (!array_key_exists($this->column, $this->resource->getAttributes())) {
            return $this->addError('Column `' . $this->column . '` not found.');
        }

        // get the list of accepted file extensions
        $this->acceptedFileExtensions = match ($this->uploadType) {
            'audio' => config('app.upload_audio_accept'),
            'document' => config('app.upload_document_accept'),
            'image' => config('app.upload_image_accept'),
            'video' => config('app.upload_video_accept'),
            default => [],
        };

        $this->fileUploaded = true;

        // validate the file
        $this->request->validate([
            'file' => [
                'required',
                'extensions:' . implode(',', $this->acceptedFileExtensions),
                'max:' . $this->maxFileSize,
            ],
        ]);

        $this->requestValidated = true;

        return true;
    }

    /**
     * Moves the file to the destination directory, updates the database, and returns the file name.
     *
     * @return bool|string
     */
    public function moveUploadedFile(): bool|string
    {
        try {
            // move the file to the public directory
            $this->filename = Str::uuid() . '.' . $this->request->file->extension();

            $this->relativePath = 'portfolio' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR .
                dbName($this->adminResource['database_id']) . DIRECTORY_SEPARATOR .
                str_replace('_', '-', Str::snake($this->resourceTypeName)) . DIRECTORY_SEPARATOR .
                $this->resource->id;
            $this->destinationPath = $this->rootPath . DIRECTORY_SEPARATOR . $this->relativePath;

            Storage::disk('public')->makeDirectory($this->relativePath);

            $this->request->file->move($this->destinationPath, $this->filename);

            $this->fileMoved = true;

            $this->uploadVerified = true;

            // update the database with the filepath
            $this->resource->update([ $this->column => $this->relativePath . DIRECTORY_SEPARATOR . $this->filename ]);

            if (!File::exists($this->destinationPath . DIRECTORY_SEPARATOR . $this->filename)) {
                return $this->addError('File could not be moved.');
            } else {
                $this->uploadVerified = true;
            }
            $this->databaseUpdated = true;

        } catch (\Exception $exception) {

            return $this->addError($exception->getMessage());
        }

        $this->uploadCompleted = true;

        return true;
    }

    public function getRootPath(): string
    {
        return $this->rootPath;
    }

    public function getRelativePath(): string|null
    {
        return $this->relativePath;
    }

    public function getDestinationPath(): string|null
    {
        return $this->destinationPath;
    }

    public function getFilename(): string|null
    {
        return $this->filename;
    }

    /**
     * Adds a message to the error message array and returns the message.
     *
     * @param string $message
     * @return string
     */
    protected function addError(string $message): string
    {
        $this->errors[] = $message;

        return $message;
    }

    /**
     * Clears the error message array.
     *
     * @return $this
     */
    public function clearErrors(): static
    {
        $this->errors = [];

        return $this;
    }

    /**
     * Set the maximum file size for an upload.
     *
     * @param int $maxFileSize
     * @return $this
     */
    public function setMaxFileSize(int $maxFileSize): static
    {
        $this->maxFileSize = $maxFileSize;

        return $this;
    }

    /**
     * Dump and display all settings and variables.
     *
     * @return void
     */
    public function dd()
    {
        dd([
            'uploadsEnabled'         => $this->uploadsEnabled,
            'maxFileSize'            => $this->maxFileSize,
            'uploadType'             => $this->uploadType,
            'UPLOAD_TYPES'           => self::UPLOAD_TYPES,
            'validColumns'           => $this->validColumns,
            'acceptedFileExtensions' => $this->acceptedFileExtensions,
            'resourceTypeId'         => $this->resourceTypeId,
            'resourceId'             => $this->resourceId,
            'resourceTypeName'       => $this->resourceTypeName,
            'adminResource'          => $this->adminResource,
            'reflectionClass'        => $this->reflectionClass,
            'resource'               => $this->resource,
            'column'                 => $this->column,
            'admin'                  => $this->admin,
            'filename'               => $this->filename,
            'rootPath'               => $this->rootPath,
            'relativePath'           => $this->relativePath,
            'destinationPath'        => $this->destinationPath,
            'errors'                 => $this->errors,
            'processes'              => [
                'fileUploaded'    => $this->fileUploaded,
                'fileValidated'   => $this->requestValidated,
                'fileMoved'       => $this->fileMoved,
                'uploadVerified'  => $this->uploadVerified,
                'databaseUpdated' => $this->databaseUpdated,
                'uploadCompleted' => $this->uploadCompleted,
            ]
        ]);
    }
}
