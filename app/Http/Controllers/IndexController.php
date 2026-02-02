<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Http\Requests\MessageStoreRequest;
use App\Models\System\Admin;
use App\Models\System\Message;
use App\Services\PermissionService;
use http\Encoding\Stream;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class IndexController extends BaseController
{
    public function __construct(PermissionService $permissionService, Request $request)
    {
        parent::__construct($permissionService);

        $this->setCurrentAdminAndUser();
    }

    public function about(): View
    {
        return view(themedTemplate('system.about'));
    }

    public function contact(): View
    {
        return view(themedTemplate('system.contact'));
    }

    /**
     * Store a submitted contact message in storage.
     *
     * @param MessageStoreRequest $messageStoreRequest
     * @return RedirectResponse
     */
    public function storeMessage(MessageStoreRequest $messageStoreRequest): RedirectResponse
    {
        $message = Message::create($messageStoreRequest->validated());

        return redirect(route('guest.index'))
            ->with('success', 'Your message has been sent. Thank you!.');
    }

    public function privacy_policy(): View
    {
        return view(themedTemplate('system.privacy-policy'));
    }

    public function terms_and_conditions(): View
    {
        return view(themedTemplate('system.terms-and-conditions'));
    }

    /**
     * Download a file from the public directory.
     *
     * @return StreamedResponse|null
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function download_from_public(): StreamedResponse|null
    {
        $filePath = request()->get('file');
        $newFileName = request()->get('name');

        if (empty($filePath)) {
            return null;
        }

        $filePath = str_replace('/', DIRECTORY_SEPARATOR, $filePath);
        $filePath = str_replace('\\', DIRECTORY_SEPARATOR, $filePath);
        $filePath = trim($filePath, DIRECTORY_SEPARATOR);

        $filePathParts = explode(DIRECTORY_SEPARATOR, $filePath);

        if (empty($newFileName)) {

            $newFileName = $filePathParts[count($filePathParts) - 1];

        } else {

            $realFileName = explode('.', $filePathParts[count($filePathParts) - 1])[0];
            $realFileExt = explode('.', $filePathParts[count($filePathParts) - 1])[1] ?? '';

            if (!empty($realFileName)) {
                if (!$newFileNameExt = explode('.', $newFileName)[1] ?? false) {
                    $newFileName = $newFileName . '.' . $realFileExt;
                }
            }
        }

        return Storage::disk('public_dir')->download($filePath, $newFileName);
    }
}
