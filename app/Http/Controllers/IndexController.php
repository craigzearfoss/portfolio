<?php

namespace App\Http\Controllers;

use App\Http\Requests\MessageStoreRequest;
use App\Models\System\Message;
use App\Services\PermissionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use PhpOffice\PhpWord\IOFactory;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\HttpFoundation\StreamedResponse;

class IndexController extends BaseController
{
    public function __construct(PermissionService $permissionService, Request $request)
    {
        parent::__construct($permissionService);
    }

    /**
     * Download a file from the public directory.
     *
     * @return StreamedResponse|null
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
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

    /**
     * Returns a Microsoft Word document from the public directory as HTML. It is not very most accurate.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|View
     * @throws \PhpOffice\PhpWord\Exception\Exception
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function view_document()
    {
        $file = request()->get('file');

        $filePath = base_path() . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . $file;

        // Load the Word document
        $phpWord = IOFactory::createReader()->load($filePath);

        // Convert to HTML
        $objWriter = IOFactory::createWriter($phpWord, 'HTML');
        $htmlContent = '';

        // Save the HTML output to a variable or temporary file
        ob_start();
        $objWriter->save('php://output');
        $htmlContent = ob_get_contents();
        ob_end_clean();

        return view('document-display', compact('htmlContent'));
    }
}
