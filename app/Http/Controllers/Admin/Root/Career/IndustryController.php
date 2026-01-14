<?php

namespace App\Http\Controllers\Admin\Root\Career;

use App\Http\Controllers\Admin\Root\BaseAdminRootController;
use App\Http\Requests\Career\StoreIndustriesRequest;
use App\Http\Requests\Career\UpdateIndustriesRequest;
use App\Models\Career\Industry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

/**
 *
 */
class IndustryController extends BaseAdminRootController
{
    /**
     * Display a listing of industries.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $perPage = $request->query('per_page', $this->perPage);

        $industries = Industry::orderBy('name', 'asc')->paginate($perPage);

        return view('admin.career.industry.index', compact('industries'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new industry.
     *
     * @return View
     */
    public function create(): View
    {
        if (!isRootAdmin()) {
            abort(403, 'Only admins with root access can add industries.');
        }

        return view('admin.career.industry.create');
    }

    /**
     * Store a newly created industry in storage.
     *
     * @param StoreIndustriesRequest $request
     * @return RedirectResponse
     */
    public function store(StoreIndustriesRequest $request): RedirectResponse
    {
        if (!isRootAdmin()) {
            abort(403, 'Only admins with root access can add industries.');
        }

        $industry = Industry::create($request->validated());

        return redirect()->route('root.career.industry.show', $industry)
            ->with('success', $industry->name . ' successfully added.');
    }

    /**
     * Display the specified industry.
     *
     * @param Industry $industry
     * @return View
     */
    public function show(Industry $industry): View
    {
        return view('admin.career.industry.show', compact('industry'));
    }

    /**
     * Show the form for editing the specified industry.
     *
     * @param Industry $industry
     * @return View
     */
    public function edit(Industry $industry): View
    {
        Gate::authorize('update-resource', $industry);

        if (!isRootAdmin()) {
            abort(403, 'Only admins with root access can edit industries.');
        }

        return view('admin.career.industry.edit', compact('industry'));
    }

    /**
     * Update the specified industry in storage.
     *
     * @param UpdateIndustriesRequest $request
     * @param Industry $industry
     * @return RedirectResponse
     */
    public function update(UpdateIndustriesRequest $request, Industry $industry): RedirectResponse
    {
        Gate::authorize('update-resource', $industry);

        if (!isRootAdmin()) {
            abort(403, 'Only admins with root access can update industries.');
        }

        $industry->update($request->validated());

        return redirect()->route('root.career.industry.show', $industry)
            ->with('success', $industry->name . ' successfully updated.');
    }

    /**
     * Remove the specified industry from storage.
     *
     * @param Industry $industry
     * @return RedirectResponse
     */
    public function destroy(Industry $industry): RedirectResponse
    {
        Gate::authorize('delete-resource', $industry);

        if (!isRootAdmin()) {
            abort(403, 'Only admins with root access can delete industries.');
        }

        $industry->delete();

        return redirect(referer('root.career.industry.index'))
            ->with('success', $industry->name . ' deleted successfully.');
    }
}
