<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Http\Controllers\Controller;
use App\Http\Requests\Portfolio\UnitStoreRequest;
use App\Http\Requests\Portfolio\UnitUpdateRequest;
use App\Models\Portfolio\Unit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UnitController extends Controller
{
    const PER_PAGE = 20;

    /**
     * Display a listing of units.
     */
    public function index(int $perPage = self::PER_PAGE): View
    {
        $units = Unit::latest()->paginate($perPage);

        return view('admin.portfolio.unit.index', compact('units'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new unit.
     */
    public function create(): View
    {
        return view('admin.portfolio.unit.create');
    }

    /**
     * Store a newly created unit in storage.
     */
    public function store(UnitStoreRequest $request): RedirectResponse
    {
        Unit::create($request->validated());

        return redirect()->route('admin.portfolio.unit.index')
            ->with('success', 'Unit created successfully.');
    }

    /**
     * Display the specified unit.
     */
    public function show(Unit $unit): View
    {
        return view('admin.portfolio.unit.show', compact('unit'));
    }

    /**
     * Show the form for editing the specified unit.
     */
    public function edit(Unit $unit): View
    {
        return view('admin.portfolio.unit.edit', compact('unit'));
    }

    /**
     * Update the specified unit in storage.
     */
    public function update(UnitUpdateRequest $request, Unit $unit): RedirectResponse
    {
        $unit->update($request->validated());

        return redirect()->route('admin.portfolio.unit.index')
            ->with('success', 'Unit updated successfully');
    }

    /**
     * Remove the specified unit from storage.
     */
    public function destroy(Unit $unit): RedirectResponse
    {
        $unit->delete();

        return redirect()->route('admin.portfolio.unit.index')
            ->with('success', 'Unit deleted successfully');
    }
}
