<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\System\AdminResource;
use App\Services\ResourceFileService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use ReflectionClass;
use ReflectionException;
use Str;

class FileController extends Controller
{
    /**
     *
     */
    const array VALID_UPLOAD_TYPES = [
        //'audio',
        'document',
        'image',
        //'video',
    ];

    const array AUDIO_COLUMNS = [
    ];

    const array DOCUMENT_COLUMNS = [
        'doc_filepath',
        'pdf_filepath',
        'other_filepath',
    ];

    const array IMAGE_COLUMNS = [
        'certificate_url',
        'icon',
        'image',
        'logo',
        'logo_small',
        'thumbnail',
    ];

    const array VIDEO_COLUMNS = [
    ];

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws ReflectionException
     */
    public function store(Request $request): RedirectResponse
    {
        $admin = loggedInAdmin();

        $fileService = new ResourceFileService();

        // validated the request
        if (true !== $retValue = $fileService->validateUpload($request, $admin)) {
            return back()->with('error', $retValue);
        }

        // move the file to the public directory
        if (true !== $retValue = $fileService->moveUploadedFile()) {
            return back()->with('error', $retValue);
        }

        return back()->with('success', 'File uploaded successfully!')
            ->with('file', $fileService->getFilename());
    }
}
