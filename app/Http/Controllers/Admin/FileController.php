<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ResourceFileService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use ReflectionException;

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

    public function removeImage()
    {
        $errors = [];

        if (!$resourceType = request()->input('resource_type')) {
            $errors[] = 'No `resource_type` specified.';
        }
        if (!$resourceId = request()->input('resource_id')) {
            $errors[] = 'No `resource_id` specified.';
        }
        if (!$column = request()->input('column')) {
            $errors[] = 'No `column` specified.';
        }
        if (!$target = request()->input('target')) {
            $target = route('admin.dashboard');
        }

        if (empty($errors)) {

            $resourceClassName = 'App\\Models\\' . trim($resourceType, '\\');



            $admin = Auth::guard('admin')->user();

            try {
                $object = new $resourceClassName;
                if (!$resourceObj = $object->find($resourceId)) {

                    $errors[] = $resourceType . ' ' . $resourceId . ' not found.';

                } else {

                    if (!canUpdate($resourceObj, $admin)) {

                        $errors[] = 'You do not have permission to update ' . $resourceType . ' ' . $resourceId . '.';

                    } else {

                        $resourceObj->{$column} = null;
                        $resourceObj->update();

                        return redirect($target)->with('success', "`{$column}` removed for ' . $resourceType . ' ' . $resourceId . '.'");
                    }
                }

            } catch (\Exception $e) {
                $errors[] = $e->getMessage();
            }
        }

        if (!empty($errors)) {
            return redirect($target)->withErrors([
                'GLOBAL' => 'Image could not be removed. ' . implode(' ', $errors)
            ]);
        }

    }
}
