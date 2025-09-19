<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Portfolio\AcademyStoreRequest;
use App\Http\Requests\Portfolio\AcademyUpdateRequest;
use App\Models\Portfolio\Academy;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Illuminate\Support\Str;

/**
 *
 */
class AcademyController extends BaseController
{
    /**
     * Display a listing of academies.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $perPage = $request->query('per_page', $this->perPage);

        $academies = Academy::orderBy('name', 'asc')->paginate($perPage);

        return view('admin.portfolio.academy.index', compact('academies'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new academy.
     *
     * @return View
     */
    public function create(): View
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can add academies.');
        }

        return view('admin.portfolio.academy.create');
    }

    /**
     * Store a newly created academy in storage.
     *
     * @param AcademyStoreRequest $request
     * @return RedirectResponse
     */
    public function store(AcademyStoreRequest $request): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can add academies.');
        }

        $academy = Academy::create($request->validated());

        return redirect(referer('admin.portfolio.academy.index'))
            ->with('success', $academy->name . ' created successfully.');
    }

    /**
     * Display the specified academy.
     *
     * @param Academy $academy
     * @return View
     */
    public function show(Academy $academy): View
    {
        return view('admin.portfolio.academy.show', compact('academy'));
    }

    /**
     * Show the form for editing the specified academy.
     *
     * @param Academy $academy
     * @return View
     */
    public function edit(Academy $academy): View
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can edit academies.');
        }

        return view('admin.portfolio.academy.edit', compact('academy'));
    }

    /**
     * Update the specified academy in storage.
     *
     * @param AcademyUpdateRequest $request
     * @param Academy $academy
     * @return RedirectResponse
     */
    public function update(AcademyUpdateRequest $request, Academy $academy): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can update academies.');
        }

        $academy->update($request->validated());

        return redirect(referer('admin.portfolio.academy.index'))
            ->with('success', $academy->name . ' updated successfully.');
    }

    /**
     * Remove the specified academy from storage.
     *
     * @param Academy $academy
     * @return RedirectResponse
     */
    public function destroy(Academy $academy): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can delete academies.');
        }

        $academy->delete();

        return redirect(str_replace(config('app.url'), '', 'admin.portfolio.academy.index'))
            ->with('success', $academy->name . ' deleted successfully.');
    }
}
