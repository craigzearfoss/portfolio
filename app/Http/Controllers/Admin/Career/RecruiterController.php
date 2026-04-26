<?php

namespace App\Http\Controllers\Admin\Career;

use App\Exports\Career\RecruitersExport;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Career\StoreRecruitersRequest;
use App\Http\Requests\Career\UpdateRecruitersRequest;
use App\Models\Career\Recruiter;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

/**
 *
 */
class RecruiterController extends BaseAdminController
{
    /**
     * Display a listing of recruiters.
     *
     * @param Request $request
     * @return View
     * @throws Exception
     */
    public function index(Request $request): View
    {
        readGate(Recruiter::class, $this->admin);

        $perPage = $request->query('per_page', $this->perPage());

        $recruiters = new Recruiter()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', Recruiter::SEARCH_ORDER_BY),
            !$this->isRootAdmin ? $this->admin : null
        )
        ->paginate($perPage)->appends(request()->except('page'));

        $pageTitle = 'Recruiters';

        return view('admin.career.recruiter.index', compact('recruiters', 'pageTitle'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new recruiter.
     *
     * @return View
     */
    public function create(): View
    {
        createGate(Recruiter::class, $this->admin);

        return view('admin.career.recruiter.create');
    }

    /**
     * Store a newly created recruiter in storage.
     *
     * @param StoreRecruitersRequest $request
     * @return RedirectResponse
     */
    public function store(StoreRecruitersRequest $request): RedirectResponse
    {
        createGate(Recruiter::class, $this->admin);

        $recruiter = Recruiter::query()->create($request->validated());

        if ($referer = $request->input('referer')) {
            return redirect($referer)->with('success', $recruiter['name'] . ' successfully added.');
        } else {
            return redirect()->route('admin.career.recruiter.show', $recruiter)
                ->with('success', $recruiter['name'] . ' successfully added.');
        }
    }

    /**
     * Display the specified recruiter.
     *
     * @param Recruiter $recruiter
     * @return View
     */
    public function show(Recruiter $recruiter): View
    {
        readGate($recruiter, $this->admin);

        list($prev, $next) = $recruiter->prevAndNextPages(
            $recruiter['id'],
            'admin.career.recruiter.show',
            null,
            [ 'name', 'asc' ]
        );

        return view('admin.career.recruiter.show', compact('recruiter', 'prev', 'next'));
    }

    /**
     * Show the form for editing the specified recruiter.
     *
     * @param Recruiter $recruiter
     * @return View
     */
    public function edit(Recruiter $recruiter): View
    {
        updateGate($recruiter, $this->admin);

        return view('admin.career.recruiter.edit', compact('recruiter'));
    }

    /**
     * Update the specified recruiter in storage.
     *
     * @param UpdateRecruitersRequest $request
     * @param Recruiter $recruiter
     * @return RedirectResponse
     */
    public function update(UpdateRecruitersRequest $request, Recruiter $recruiter): RedirectResponse
    {
        $recruiter->update($request->validated());

        updateGate($recruiter, $this->admin);

        if ($referer = $request->input('referer')) {
            return redirect($referer)->with('success', $recruiter['name'] . ' successfully updated.');
        } else {
            return redirect()->route('admin.career.recruiter.show', $recruiter)
                ->with('success', $recruiter['name'] . ' successfully updated.');
        }
    }

    /**
     * Remove the specified recruiter from storage.
     *
     * @param Recruiter $recruiter
     * @return RedirectResponse
     */
    public function destroy(Recruiter $recruiter): RedirectResponse
    {
        deleteGate($recruiter, $this->admin);

        $recruiter->delete();

        return redirect(referer('admin.career.recruiter.index'))
            ->with('success', $recruiter['name'] . ' deleted successfully.');
    }

    /**
     * Export Microsoft Excel file.
     *
     * @return BinaryFileResponse
     */
    public function export(): BinaryFileResponse
    {
        readGate(Recruiter::class, $this->admin);

        $filename = request()->has('timestamp')
            ? 'recruiters_' . date("Y-m-d-His") . '.xlsx'
            : 'recruiters.xlsx';

        return Excel::download(new RecruitersExport(), $filename);
    }
}
