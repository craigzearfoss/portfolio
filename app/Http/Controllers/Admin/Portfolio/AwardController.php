<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Enums\PermissionEntityTypes;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Portfolio\StoreAwardsRequest;
use App\Http\Requests\Portfolio\UpdateAwardsRequest;
use App\Models\Portfolio\Award;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

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
     */
    public function index(Request $request): View
    {
        readGate(PermissionEntityTypes::RESOURCE, 'award', $this->admin);

        $perPage = $request->query('per_page', $this->perPage());

        $awards = Award::searchQuery($request->all(), !empty($this->owner->root) ? null : $this->owner)
            ->orderBy('owner_id')
            ->orderBy('name')
            ->paginate($perPage)->appends(request()->except('page'));

        $pageTitle = ($this->isRootAdmin && !empty($owner_id)) ? $this->owner->name . ' Awards' : 'Awards';

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
        createGate(PermissionEntityTypes::RESOURCE, 'award', $this->admin);

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
        createGate(PermissionEntityTypes::RESOURCE, 'award', $this->admin);

        $award = new Award()->create($request->validated());

        return redirect()->route('admin.portfolio.award.show', $award)
            ->with('success', $award->name . ' successfully added.');
    }

    /**
     * Display the specified award.
     *
     * @param Award $award
     * @return View
     */
    public function show(Award $award): View
    {
        readGate(PermissionEntityTypes::RESOURCE, $award, $this->admin);

        list($prev, $next) = Award::prevAndNextPages($award->id,
            'admin.portfolio.award.show',
            $this->owner->id ?? null,
            ['name', 'asc']);

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
        updateGate(PermissionEntityTypes::RESOURCE, $award, $this->admin);

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

        updateGate(PermissionEntityTypes::RESOURCE, $award, $this->admin);

        return redirect()->route('admin.portfolio.award.show', $award)
            ->with('success', $award->name . ' successfully updated.');
    }

    /**
     * Remove the specified award from storage.
     *
     * @param Award $award
     * @return RedirectResponse
     */
    public function destroy(Award $award): RedirectResponse
    {
        deleteGate(PermissionEntityTypes::RESOURCE, $award, $this->admin);

        $award->delete();

        return redirect(referer('admin.portfolio.award.index'))
            ->with('success', $award->name . ' deleted successfully.');
    }
}
