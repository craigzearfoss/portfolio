<?php

namespace App\Http\Controllers\System;

use App\Models\System\Backup;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;
use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

/**
 *
 */
class BackupController extends BaseSystemController
{
    /**
     * Display a listing of units.
     *
     * @param Request $request
     * @return View
     * @throws Exception
     */
    public function index(Request $request): View
    {
        if (!$this->isRootAdmin) {
            abort(403, 'Not authorized.');
        }

        $perPage = $request->query('per_page', $this->perPage());

        // get database backups
        $databaseBackups = new Backup()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', Backup::SEARCH_ORDER_BY),
            !$this->isRootAdmin ? $this->admin : null
        )->paginate($perPage)->appends(request()->except('page'));

        // get image file backups
        $imageFileBackups = $this->getImageFileBackups();

        $pageTitle = 'Backups';

        return view('system.backup.index',
            compact('databaseBackups', 'imageFileBackups', 'pageTitle'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Download a backup file.
     *
     * @param Backup $backup
     * @return BinaryFileResponse
     */
    public function download(Backup $backup): BinaryFileResponse
    {
        if (!$this->isRootAdmin) {
            abort(403, 'Not authorized.');
        }

        // delete the file
        if (!file_exists($backup['filepath'])) {
            abort(500, 'File not found.');
        }

        return response()->download($backup['filepath']);
    }

    /**
     * Remove the specified unit from storage.
     *
     * @param Backup $backup
     * @return RedirectResponse
     */
    public function destroy(Backup $backup): RedirectResponse
    {
        if (!$this->isRootAdmin) {
            abort(403, 'Not authorized.');
        }

        // delete the file
        if (file_exists($backup['filepath'])) {
            unlink($backup['filepath']);
        }
        if (file_exists($backup['filepath'])) {
            return redirect()->back()->withErrors(['GLOBAL' => 'File could not be deleted.']);
        }

        // delete the entry from the system backups table
        $backup->delete();

        return redirect(referer('system.backup.index'))
            ->with('success', $backup['name'] . ' deleted successfully.');
    }

    /**
     * Runs the console commands app:backup-databases.
     *
     * @return RedirectResponse
     */
    public function backupDatabases(): RedirectResponse
    {
        if (!$this->isRootAdmin) {
            abort(403, 'Not authorized.');
        }

        Artisan::call('app:backup-databases');

        return redirect()->back()->with('success', __('Database backup has been created.'));
    }

    /**
     * Runs the console commands app:backup-image-files.
     *
     * @return RedirectResponse
     */
    public function backupImageFiles(): RedirectResponse
    {
        if (!$this->isRootAdmin) {
            abort(403, 'Not authorized.');
        }

        Artisan::call('app:backup-image-files');

        return redirect()->back()->with('success', __('Image files have been backed up.'));
    }

    /**
     * @return array|SplFileInfo
     */
    protected function getImageFileBackups(): array|SplFileInfo
    {
        // determine the backup root directory
        if (!$backupDirectoryRoot = config('app.backup_directory')) {
            $backupDirectoryRoot = storage_path() . DIRECTORY_SEPARATOR . 'backups';
        }
        $backupDirectoryRoot .= DIRECTORY_SEPARATOR . 'files';;

        // make sure the backup root directory exists
        if (!File::exists($backupDirectoryRoot)) {
            return [];
        } else {
            return File::directories($backupDirectoryRoot);
        }
    }
}
