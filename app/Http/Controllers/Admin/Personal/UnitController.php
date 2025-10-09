<?php

namespace App\Http\Controllers\Admin\Personal;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Personal\StoreUnitRequest;
use App\Http\Requests\Personal\UpdateUnitRequest;
use App\Models\Personal\Unit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 *
 */
class UnitController extends BaseController
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
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can add units.');
        }
        return view('admin.personal.unit.create');
    }

    /**
     * Store a newly created unit in storage.
     *
     * @param StoreUnitRequest $storeUnitRequest
     * @return RedirectResponse
     */
    public function store(StoreUnitRequest $storeUnitRequest): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can add units.');
        }

        $unit = Unit::create($storeUnitRequest->validated());

        return redirect(referer('admin.personal.unit.index'))
            ->with('success', $unit->name . $unit->name . ' added successfully.');
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
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can edit units.');
        }

        return view('admin.personal.unit.edit', compact('unit'));
    }

    /**
     * Update the specified unit in storage.
     *
     * @param UpdateUnitRequest $updateUnitRequest
     * @param Unit $unit
     * @return RedirectResponse
     */
    public function update(UpdateUnitRequest $updateUnitRequest, Unit $unit): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can update units.');
        }

        $unit->update($updateUnitRequest->validated());

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
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can delete units.');
        }

        $unit->delete();

        return redirect(referer('admin.personal.unit.index'))
            ->with('success', $unit->name . ' deleted successfully.');
    }
}
