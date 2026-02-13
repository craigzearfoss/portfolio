<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Enums\PermissionEntityTypes;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Portfolio\StoreEducationsRequest;
use App\Http\Requests\Portfolio\UpdateEducationsRequest;
use App\Models\Portfolio\Education;
use App\Models\System\Owner;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

/**
 *
 */
class EducationController extends BaseAdminController
{
    /**
     * Display a listing of education.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        readGate(PermissionEntityTypes::RESOURCE, 'education', $this->admin);

        $perPage = $request->query('per_page', $this->perPage());

        $educations = Education::searchQuery($request->all(), !empty($this->owner->root) ? null : $this->owner)
            ->orderBy('owner_id', 'asc')
            ->orderBy('enrollment_year', 'desc')->orderBy('enrollment_month', 'desc')
            ->paginate($perPage)->appends(request()->except('page'));

        $pageTitle = ($this->isRootAdmin && !empty($owner_id)) ? $this->owner->name . ' Education' : 'Education';

        return view('admin.portfolio.education.index', compact('educations', 'pageTitle'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new education.
     *
     * @return View
     */
    public function create(): View
    {
        createGate(PermissionEntityTypes::RESOURCE, 'education', $this->admin);

        return view('admin.portfolio.education.create');
    }

    /**
     * Store a newly created education in storage.
     *
     * @param StoreEducationsRequest $request
     * @return RedirectResponse
     */
    public function store(StoreEducationsRequest $request): RedirectResponse
    {
        createGate(PermissionEntityTypes::RESOURCE, 'education', $this->admin);

        $education = Education::create($request->validated());

        return redirect()->route('admin.portfolio.education.show', $education)
            ->with('success', $education->name . ' education successfully added.');
    }

    /**
     * Display the specified education.
     *
     * @param Education $education
     * @return View
     */
    public function show(Education $education): View
    {
        readGate(PermissionEntityTypes::RESOURCE, $education, $this->admin);

        list($prev, $next) = Education::prevAndNextPages($education->id,
            'admin.portfolio.education.show',
            $this->owner->id ?? null,
            ['graduation_year', 'desc']);

        return view('admin.portfolio.education.show', compact('education', 'prev', 'next'));
    }

    /**
     * Show the form for editing the specified education.
     *
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $education = Education::findOrFail($id);

        updateGate(PermissionEntityTypes::RESOURCE, $education, $this->admin);

        return view('admin.portfolio.education.edit', compact('education'));
    }

    /**
     * Update the specified education in storage.
     *
     * @param UpdateEducationsRequest $request
     * @param Education $education
     * @return RedirectResponse
     */
    public function update(UpdateEducationsRequest $request,
                           Education               $education): RedirectResponse
    {
        $education->update($request->validated());

        updateGate(PermissionEntityTypes::RESOURCE, $education, $this->admin);

        return redirect()->route('admin.portfolio.education.show', $education)
            ->with('success', $education->name . ' education successfully updated.');
    }

    /**
     * Remove the specified education from storage.
     *
     * @param Education $education
     * @return RedirectResponse
     */
    public function destroy(Education $education): RedirectResponse
    {
        deleteGate(PermissionEntityTypes::RESOURCE, $education, $this->admin);

        $education->delete();

        return redirect(referer('admin.portfolio.education.index'))
            ->with('success', $education->name . ' education deleted successfully.');
    }
}
