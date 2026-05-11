<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Models\System\Backup;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

/**
 *
 */
class BackupController extends BaseAdminController
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

        $backups = new Backup()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', Backup::SEARCH_ORDER_BY),
            !$this->isRootAdmin ? $this->admin : null
        )->paginate($perPage)->appends(request()->except('page'));

        $pageTitle = 'Backups';

        return view('admin.system.backup.index', compact('backups', 'pageTitle'))
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

        return redirect(referer('admin.system.backup.index'))
            ->with('success', $backup['name'] . ' deleted successfully.');
    }
}
