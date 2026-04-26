<?php

namespace App\Http\Controllers\Admin\System;

use App\Exports\System\SessionsExport;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Models\System\Session;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

/**
 *
 */
class SessionController extends BaseAdminController
{
    /**
     * Display a listing of sessions.
     *
     * @param Request $request
     * @return View|RedirectResponse
     */
    public function index(Request $request): View|RedirectResponse
    {
        if (!$this->isRootAdmin) {
            abort(403, 'Not authorized.');
        }

        $perPage = $request->query('per_page', $this->perPage());

        $sessions = new Session()->searchQuery(
            $request->all(),
            request()->input('sort') ?? implode('|', Session::SEARCH_ORDER_BY)
        )
            ->paginate($perPage)->appends(request()->except('page'));

        $pageTitle = 'Sessions';

        return view('admin.system.session.index', compact('sessions', 'pageTitle'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Export Microsoft Excel file.
     *
     * @return BinaryFileResponse
     */
    public function export(): BinaryFileResponse
    {
        readGate(Session::class, $this->admin);

        $filename = request()->has('timestamp')
            ? 'sessions_' . date("Y-m-d-His") . '.xlsx'
            : 'sessions.xlsx';

        return Excel::download(new SessionsExport(), $filename);
    }
}
