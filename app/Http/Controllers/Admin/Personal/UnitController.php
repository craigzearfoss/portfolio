<?php

namespace App\Http\Controllers\Admin\Personal;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Personal\StoreUnitsRequest;
use App\Http\Requests\Personal\UpdateUnitsRequest;
use App\Models\Personal\Unit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

/**
 *
 */
class UnitController extends BaseAdminController
{
    /**
     * Display a listing of units.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $perPage = $request->query('per_page', $this->perPage());

        $units = Unit::where('name', '!=', 'other')->orderBy('name', 'asc')->paginate($perPage);

        $pageTitle = 'Units';

        return view('admin.personal.unit.index', compact('units', 'pageTitle'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new unit.
     *
     * @return View
     */
    public function create(): View
    {
        if (!isRootAdmin()) {
            abort(403, 'Only admins with root access can add units.');
        }
        return view('admin.personal.unit.create');
    }

    /**
     * Store a newly created unit in storage.
     *
     * @param StoreUnitsRequest $request
     * @return RedirectResponse
     */
    public function store(StoreUnitsRequest $request): RedirectResponse
    {
        if (!isRootAdmin()) {
            abort(403, 'Only admins with root access can add units.');
        }

        $unit = Unit::create($request->validated());

        return redirect()->route('admin.personal.unit.show', $unit->id)
            ->with('success', $unit->name . $unit->name . ' successfully added.');
    }

    /**
     * Display the specified unit.
     *
     * @param Unit $unit
     * @return View
     */
    public function show(Unit $unit): View
    {
        list($prev, $next) = Unit::prevAndNextPages($unit->id,
            'admin.personal.unit.show',
            $this->owner->id ?? null,
            ['name', 'asc']);

        return view('admin.personal.unit.show', compact('unit', 'prev', 'next'));
    }

    /**
     * Show the form for editing the specified unit.
     *
     * @param Unit $unit
     * @return View
     */
    public function edit(Unit $unit): View
    {
        Gate::authorize('update-resource', $unit);

        return view('admin.personal.unit.edit', compact('unit'));
    }

    /**
     * Update the specified unit in storage.
     *
     * @param UpdateUnitsRequest $request
     * @param Unit $unit
     * @return RedirectResponse
     */
    public function update(UpdateUnitsRequest $request, Unit $unit): RedirectResponse
    {
        Gate::authorize('update-resource', $unit);

        $unit->update($request->validated());

        return redirect()->route('admin.personal.unit.show', $unit)
            ->with('success', $unit->name . ' successfully updated.');
    }

    /**
     * Remove the specified unit from storage.
     *
     * @param Unit $unit
     * @return RedirectResponse
     */
    public function destroy(Unit $unit): RedirectResponse
    {
        Gate::authorize('delete-resource', $unit);

        $unit->delete();

        return redirect(referer('admin.personal.unit.index'))
            ->with('success', $unit->name . ' deleted successfully.');
    }
}
