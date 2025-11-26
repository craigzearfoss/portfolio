<?php

namespace App\Http\Controllers\Admin\Personal;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Personal\StoreUnitsRequest;
use App\Http\Requests\Personal\UpdateUnitsRequest;
use App\Models\Personal\Unit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $perPage = $request->query('per_page', $this->perPage);

        $units = Unit::orderBy('name', 'asc')->paginate($perPage);

        return view('admin.personal.unit.index', compact('units'))
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
     * @param StoreUnitsRequest $storeUnitsRequest
     * @return RedirectResponse
     */
    public function store(StoreUnitsRequest $storeUnitsRequest): RedirectResponse
    {
        if (!isRootAdmin()) {
            abort(403, 'Only admins with root access can add units.');
        }

        $unit = Unit::create($storeUnitsRequest->validated());

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
        return view('admin.personal.unit.show', compact('unit'));
    }

    /**
     * Show the form for editing the specified unit.
     *
     * @param Unit $unit
     * @return View
     */
    public function edit(Unit $unit): View
    {
        if (!isRootAdmin()) {
            abort(403, 'Only admins with root access can edit units.');
        }

        return view('admin.personal.unit.edit', compact('unit'));
    }

    /**
     * Update the specified unit in storage.
     *
     * @param UpdateUnitsRequest $updateUnitsRequest
     * @param Unit $unit
     * @return RedirectResponse
     */
    public function update(UpdateUnitsRequest $updateUnitsRequest, Unit $unit): RedirectResponse
    {
        if (!isRootAdmin()) {
            abort(403, 'Only admins with root access can update units.');
        }

        $unit->update($updateUnitsRequest->validated());

        return redirect(referer('admin.personal.unit.index'))
            ->with('success', $unit->name . ' updated successfully.');
    }

    /**
     * Remove the specified unit from storage.
     *
     * @param Unit $unit
     * @return RedirectResponse
     */
    public function destroy(Unit $unit): RedirectResponse
    {
        if (!isRootAdmin()) {
            abort(403, 'Only admins with root access can delete units.');
        }

        $unit->delete();

        return redirect(referer('admin.personal.unit.index'))
            ->with('success', $unit->name . ' deleted successfully.');
    }
}
