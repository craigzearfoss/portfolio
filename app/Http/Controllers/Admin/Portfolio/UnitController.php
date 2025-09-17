<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Portfolio\UnitStoreRequest;
use App\Http\Requests\Portfolio\UnitUpdateRequest;
use App\Models\Portfolio\Unit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Illuminate\Support\Str;

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
        $perPage= $request->query('per_page', $this->perPage);

        $units = Unit::orderBy('sequence', 'asc')->paginate($perPage);

        return view('admin.portfolio.unit.index', compact('units'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new unit.
     *
     * @param Request $request
     * @return View
     */
    public function create(Request $request): View
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can add units.');
        }

        $referer = $request->headers->get('referer');

        return view('admin.portfolio.unit.create', compact('referer'));
    }

    /**
     * Store a newly created unit in storage.
     *
     * @param UnitStoreRequest $request
     * @return RedirectResponse
     */
    public function store(UnitStoreRequest $request): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can add units.');
        }

        $unit = Unit::create($request->validated());

        if (!empty($referer)) {
            return redirect(str_replace(config('app.url'), '', $referer))
                ->with('success', $unit->name . $unit->name . ' created successfully.');
        } else {
            return redirect()->route('admin.portfolio.unit.index')
                ->with('success', $unit->name . ' created successfully.');
        }
    }

    /**
     * Display the specified unit.
     *
     * @param Unit $unit
     * @return View
     */
    public function show(Unit $unit): View
    {
        return view('admin.portfolio.unit.show', compact('unit'));
    }

    /**
     * Show the form for editing the specified unit.
     *
     * @param Unit $unit
     * @param Request $request
     * @return View
     */
    public function edit(Unit $unit, Request $request): View
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can edit units.');
        }

        $referer = $request->headers->get('referer');

        return view('admin.portfolio.unit.edit', compact('unit'));
    }

    /**
     * Update the specified unit in storage.
     *
     * @param UnitUpdateRequest $request
     * @param Unit $unit
     * @return RedirectResponse
     */
    public function update(UnitUpdateRequest $request, Unit $unit): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can update units.');
        }

        // Validate the posted data and generated slug.
        $validatedData = $request->validated();
        $request->merge([ 'slug' => Str::slug($validatedData['name']) ]);
        $request->validate(['slug' => [ Rule::unique('posts', 'slug') ] ]);
        $unit->update($request->validated());

        $referer = $request->input('referer');

        if (!empty($referer)) {
            return redirect(str_replace(config('app.url'), '', $referer))
                ->with('success', $unit->name . ' updated successfully.');
        } else {
            return redirect()->route('admin.portfolio.unit.index')
                 ->with('success', $unit->name . ' updated successfully');
        }
    }

    /**
     * Remove the specified unit from storage.
     *
     * @param Unit $unit
     * @param Request $request
     * @return RedirectResponse
     */
    public function destroy(Unit $unit, Request $request): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can delete units.');
        }

        $unit->delete();

        $referer = $request->input('referer');

        if (!empty($referer)) {
            return redirect(str_replace(config('app.url'), '', $referer))
                ->with('success', $unit->name . ' deleted successfully.');
        } else {
            return redirect()->route('admin.portfolio.unit.index')
                ->with('success', $unit->name . ' deleted successfully');
        }
    }
}
