<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Exports\Portfolio\AwardsExport;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Portfolio\StoreAwardsRequest;
use App\Http\Requests\Portfolio\UpdateAwardsRequest;
use App\Models\Portfolio\Award;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

/**
 *
 */
class AwardController extends BaseAdminController
{
    /**
     * Display a listing of award.
     *
     * @param Request $request
     * @return View
     * @throws Exception
     */
    public function index(Request $request): View
    {
        readGate(Award::class, $this->admin);

        $perPage = $request->query('per_page', $this->perPage());

        $awards = new Award()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', Award::SEARCH_ORDER_BY),
            $this->singleAdminMode || !$this->isRootAdmin ? $this->admin : null
        )
        ->paginate($perPage)->appends(request()->except('page'));

        $pageTitle = ($this->owner->name  ?? '') . ' Awards';

        return view('admin.portfolio.award.index', compact('awards', 'pageTitle'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new award.
     *
     * @return View
     */
    public function create(): View
    {
        createGate(Award::class, $this->admin);

        return view('admin.portfolio.award.create');
    }

    /**
     * Store a newly created award in storage.
     *
     *
     * @param StoreAwardsRequest $request
     * @return RedirectResponse
     */
    public function store(StoreAwardsRequest $request): RedirectResponse
    {
        createGate(Award::class, $this->admin);

        $award = Award::query()->create($request->validated());

        if ($referer = $request->get('referer')) {
            return redirect($referer)->with('success', $award['name'] . ' successfully added.');
        } else {
            return redirect()->route('admin.portfolio.award.show', $award)
                ->with('success', $award['name'] . ' successfully added.');
        }
    }

    /**
     * Display the specified award.
     *
     * @param Award $award
     * @return View
     */
    public function show(Award $award): View
    {
        readGate($award, $this->admin);

        list($prev, $next) = $award->prevAndNextPages(
            $award['id'],
            'admin.portfolio.award.show',
            $this->owner ?? null,
            [ 'name', 'asc' ]
        );

        return view('admin.portfolio.award.show', compact('award', 'prev', 'next'));
    }

    /**
     * Show the form for editing the specified award.
     *
     * @param Award $award
     * @return View
     */
    public function edit(Award $award): View
    {
        updateGate($award, $this->admin);

        return view('admin.portfolio.award.edit', compact('award'));
    }

    /**
     * Update the specified award in storage.
     *
     * @param UpdateAwardsRequest $request
     * @param Award $award
     * @return RedirectResponse
     */
    public function update(UpdateAwardsRequest $request, Award $award): RedirectResponse
    {
        $award->update($request->validated());

        updateGate($award, $this->admin);

        if ($referer = $request->get('referer')) {
            return redirect($referer)->with('success', $award['name'] . ' successfully updated.');
        } else {
            return redirect()->route('admin.portfolio.award.show', $award)
                ->with('success', $award['name'] . ' successfully updated.');
        }
    }

    /**
     * Remove the specified award from storage.
     *
     * @param Award $award
     * @return RedirectResponse
     */
    public function destroy(Award $award): RedirectResponse
    {
        deleteGate($award, $this->admin);

        $award->delete();

        return redirect(referer('admin.portfolio.award.index'))
            ->with('success', $award['name'] . ' deleted successfully.');
    }

    /**
     * @return BinaryFileResponse
     */
    public function export(): BinaryFileResponse
    {
        $filename = request()->has('timestamp')
            ? 'awards_' . date("Y-m-d-His") . '.xlsx'
            : 'awards.xlsx';

        return Excel::download(new AwardsExport(), $filename);
    }
}
