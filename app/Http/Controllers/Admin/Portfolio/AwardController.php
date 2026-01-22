<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Portfolio\StoreAwardsRequest;
use App\Http\Requests\Portfolio\UpdateAwardsRequest;
use App\Models\Portfolio\Award;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

/**
 *
 */
class AwardController extends BaseAdminController
{
    /**
     * Display a listing of awards.
     *
     * @param Request $request
     * @return View
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function index(Request $request): View
    {
        $perPage = $request->query('per_page', $this->perPage());

        if (!empty($this->owner)) {
            $awards = Award::where('owner_id', $this->owner->id)->orderBy('name', 'asc')->paginate($perPage);
        } else {
            $awards = Award::orderBy('name', 'asc')->paginate($perPage);
        }

        $pageTitle = empty($this->owner) ? 'Awards' : $this->owner->name . ' Awards';

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
        $award = Award::create($request->validated());

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
        return view('admin.portfolio.award.show', compact('award'));
    }

    /**
     * Show the form for editing the specified award.
     *
     * @param Award $award
     * @return View
     */
    public function edit(Award $award): View
    {
        Gate::authorize('update-resource', $award);

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
        Gate::authorize('update-resource', $award);

        $award->update($request->validated());

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
        Gate::authorize('delete-resource', $award);

        $award->delete();

        return redirect(referer('admin.portfolio.award.index'))
            ->with('success', $award->name . ' deleted successfully.');
    }
}
