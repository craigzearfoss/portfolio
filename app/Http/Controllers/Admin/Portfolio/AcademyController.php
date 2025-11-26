<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Portfolio\StoreAcademiesRequest;
use App\Http\Requests\Portfolio\UpdateAcademiesRequest;
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
class AcademyController extends BaseAdminController
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

        $academies = Academy::where('name', '!=', 'other')->orderBy('name', 'asc')->paginate($perPage);

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
        if (!isRootAdmin()) {
            abort(403, 'Only admins with root access can add academies.');
        }

        return view('admin.portfolio.academy.create');
    }

    /**
     * Store a newly created academy in storage.
     *
     * @param StoreAcademiesRequest $storeAcademiesRequest
     * @return RedirectResponse
     */
    public function store(StoreAcademiesRequest $storeAcademiesRequest): RedirectResponse
    {
        if (!isRootAdmin()) {
            abort(403, 'Only admins with root access can add academies.');
        }

        $academy = Academy::create($storeAcademiesRequest->validated());

        return redirect()->route('admin.portfolio.academy.show', $academy)
            ->with('success', $academy->name . ' successfully added.');
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
        if (!isRootAdmin()) {
            abort(403, 'Only admins with root access can edit academies.');
        }

        return view('admin.portfolio.academy.edit', compact('academy'));
    }

    /**
     * Update the specified academy in storage.
     *
     * @param UpdateAcademiesRequest $updateAcademiesRequest
     * @param Academy $academy
     * @return RedirectResponse
     */
    public function update(UpdateAcademiesRequest $updateAcademiesRequest, Academy $academy): RedirectResponse
    {
        if (!isRootAdmin()) {
            abort(403, 'Only admins with root access can update academies.');
        }

        $academy->update($updateAcademiesRequest->validated());

        return redirect()->route('admin.portfolio.academy.show', $academy)
            ->with('success', $academy->name . ' successfully updated.');
    }

    /**
     * Remove the specified academy from storage.
     *
     * @param Academy $academy
     * @return RedirectResponse
     */
    public function destroy(Academy $academy): RedirectResponse
    {
        if (!isRootAdmin()) {
            abort(403, 'Only admins with root access can delete academies.');
        }

        $academy->delete();

        return redirect(route('admin.portfolio.academy.index'))
            ->with('success', $academy->name . ' deleted successfully.');
    }
}
