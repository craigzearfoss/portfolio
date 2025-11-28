<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Http\Controllers\Controller;
use App\Http\Requests\Portfolio\StoreAwardsRequest;
use App\Http\Requests\Portfolio\UpdateAwardsRequest;
use App\Models\Portfolio\Award;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class AwardController extends Controller
{
    /**
     * Display a listing of awards.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $perPage = $request->query('per_page', $this->perPage);

        $awards = Award::orderBy('name', 'asc')->paginate($perPage);

        return view('admin.portfolio.award.index', compact('awards'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new award.
     *
     * @return View
     */
    public function create(): View
    {
        if (! Gate::allows('root-only')) {
            abort(403, 'Unauthorized action.');
        }
        Gate::authorize('create-get', Auth::guard('admin')->user());
        return view('admin.portfolio.award.create');
    }

    /**
     * Store a newly created award in storage.
     *
     *
     * @param StoreAwardsRequest $StoreAwardsRequest
     * @return RedirectResponse
     */
    public function store(StoreAwardsRequest $StoreAwardsRequest): RedirectResponse
    {
        $award = Award::create($StoreAwardsRequest->validated());

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
        return view('admin.portfolio.award.edit', compact('award'));
    }

    /**
     * Update the specified award in storage.
     *
     * @param UpdateAwardsRequest $UpdateAwardsRequest
     * @param Award $award
     * @return RedirectResponse
     */
    public function update(UpdateAwardsRequest $UpdateAwardsRequest, Award $award): RedirectResponse
    {
        $award->update($UpdateAwardsRequest->validated());

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
        $award->delete();

        return redirect(referer('admin.portfolio.award.index'))
            ->with('success', $award->name . ' deleted successfully.');
    }
}
