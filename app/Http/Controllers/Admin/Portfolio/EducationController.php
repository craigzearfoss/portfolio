<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Exports\Portfolio\EducationsExport;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Portfolio\StoreEducationsRequest;
use App\Http\Requests\Portfolio\UpdateEducationsRequest;
use App\Models\Portfolio\Education;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

/**
 *
 */
class EducationController extends BaseAdminController
{
    /**
     * Display a listing of education.
     *
     * @param Request $request
     * @return View
     * @throws Exception
     */
    public function index(Request $request): View
    {
        readGate(Education::class, $this->admin);

        $perPage = $request->query('per_page', $this->perPage());

        $educations = new Education()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', Education::SEARCH_ORDER_BY),
            !$this->isRootAdmin ? $this->admin : null
        )
        ->orderBy('enrollment_date', 'desc')
        ->paginate($perPage)->appends(request()->except('page'));

        $pageTitle = ($this->owner->name  ?? '') . ' Education';

        return view('admin.portfolio.education.index', compact('educations', 'pageTitle'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new education.
     *
     * @return View
     */
    public function create(): View
    {
        createGate(Education::class, $this->admin);

        return view('admin.portfolio.education.create');
    }

    /**
     * Store a newly created education in storage.
     *
     * @param StoreEducationsRequest $request
     * @return RedirectResponse
     */
    public function store(StoreEducationsRequest $request): RedirectResponse
    {
        createGate(Education::class, $this->admin);

        $education = Education::query()->create($request->validated());

        if ($referer = $request->input('referer')) {
            return redirect($referer)->with('success', $education['name'] . ' education successfully added.');
        } else {
            return redirect()->route('admin.portfolio.education.show', $education)
                ->with('success', $education['name'] . ' education successfully added.');
        }
    }

    /**
     * Display the specified education.
     *
     * @param Education $education
     * @return View
     */
    public function show(Education $education): View
    {
        readGate($education, $this->admin);

        list($prev, $next) = $education->prevAndNextPages(
            $education['id'],
            'admin.portfolio.education.show',
            $this->owner ?? null,
            [ 'graduation_date', 'desc' ]
        );

        return view('admin.portfolio.education.show', compact('education', 'prev', 'next'));
    }

    /**
     * Show the form for editing the specified education.
     *
     * @param Education $education
     * @return View
     */
    public function edit(Education $education): View
    {
        updateGate($education, $this->admin);

        return view('admin.portfolio.education.edit', compact('education'));
    }

    /**
     * Update the specified education in storage.
     *
     * @param UpdateEducationsRequest $request
     * @param Education $education
     * @return RedirectResponse
     */
    public function update(UpdateEducationsRequest $request,
                           Education               $education): RedirectResponse
    {
        $education->update($request->validated());

        updateGate($education, $this->admin);

        if ($referer = $request->input('referer')) {
            return redirect($referer)->with('success', $education['name'] . ' successfully updated.');
        } else {
            return redirect()->route('admin.portfolio.education.show', $education)
                ->with('success', $education['name'] . ' education successfully updated.');
        }
    }

    /**
     * Remove the specified education from storage.
     *
     * @param Education $education
     * @return RedirectResponse
     */
    public function destroy(Education $education): RedirectResponse
    {
        deleteGate($education, $this->admin);

        $education->delete();

        return redirect(referer('admin.portfolio.education.index'))
            ->with('success', $education['name'] . ' education deleted successfully.');
    }

    /**
     * Export Microsoft Excel file.
     *
     * @return BinaryFileResponse
     */
    public function export(): BinaryFileResponse
    {
        readGate(Education::class, $this->admin);

        $filename = request()->has('timestamp')
            ? 'educations_' . date("Y-m-d-His") . '.xlsx'
            : 'educations.xlsx';

        return Excel::download(new EducationsExport(), $filename);
    }
}
