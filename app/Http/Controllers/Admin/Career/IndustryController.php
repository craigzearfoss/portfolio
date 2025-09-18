<?php

namespace App\Http\Controllers\Admin\Career;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Career\IndustryStoreRequest;
use App\Http\Requests\Career\IndustryUpdateRequest;
use App\Models\Career\Industry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Illuminate\Support\Str;

/**
 *
 */
class IndustryController extends BaseController
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

        $industries = Industry::latest()->paginate($perPage);

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
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can add industries.');
        }

        return view('admin.career.industry.create');
    }

    /**
     * Store a newly created industry in storage.
     *
     * @param IndustryStoreRequest $request
     * @return RedirectResponse
     */
    public function store(IndustryStoreRequest $request): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can add industries.');
        }

        $industry = Industry::create($request->validated());

        return redirect(referer('admin.career.industry.index'))
            ->with('success', $industry->name . ' created successfully.');
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
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can edit industries.');
        }

        return view('admin.career.industry.edit', compact('industry'));
    }

    /**
     * Update the specified industry in storage.
     *
     * @param IndustryUpdateRequest $request
     * @param Industry $industry
     * @return RedirectResponse
     */
    public function update(IndustryUpdateRequest $request, Industry $industry): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can update industries.');
        }

        $industry->update($request->validated());

        return redirect(referer('admin.career.industry.index'))
            ->with('success', $industry->name . ' updated successfully.');
    }

    /**
     * Remove the specified industry from storage.
     *
     * @param Industry $industry
     * @return RedirectResponse
     */
    public function destroy(Industry $industry): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can delete industries.');
        }

        $industry->delete();

        return redirect(referer('admin.career.industry.index'))
            ->with('success', $industry->name . ' deleted successfully.');
    }
}
