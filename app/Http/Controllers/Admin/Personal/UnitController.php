<?php

namespace App\Http\Controllers\Admin\Personal;

use App\Enums\PermissionEntityTypes;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Personal\StoreUnitsRequest;
use App\Http\Requests\Personal\UpdateUnitsRequest;
use App\Models\Personal\Unit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
        readGate(PermissionEntityTypes::RESOURCE, 'unit', $this->admin);

        $perPage = $request->query('per_page', $this->perPage());

        $units = new Unit()->where('name', '!=', 'other')
            ->orderBy('name')->paginate($perPage)
            ->appends(request()->except('page'));

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
        createGate(PermissionEntityTypes::RESOURCE, 'unit', $this->admin);

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
        createGate(PermissionEntityTypes::RESOURCE, 'unit', $this->admin);

        $unit = new Unit()->create($request->validated());

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
        readGate(PermissionEntityTypes::RESOURCE, $unit, $this->admin);

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
        updateGate(PermissionEntityTypes::RESOURCE, $unit, $this->admin);

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
        $unit->update($request->validated());

        updateGate(PermissionEntityTypes::RESOURCE, $unit, $this->admin);

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
        deleteGate(PermissionEntityTypes::RESOURCE, $unit, $this->admin);

        $unit->delete();

        return redirect(referer('admin.personal.unit.index'))
            ->with('success', $unit->name . ' deleted successfully.');
    }
}
