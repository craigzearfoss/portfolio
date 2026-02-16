<?php

namespace App\Http\Controllers\Admin\Career;

use App\Enums\PermissionEntityTypes;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Career\StoreIndustriesRequest;
use App\Http\Requests\Career\UpdateIndustriesRequest;
use App\Models\Career\Industry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 *
 */
class IndustryController extends BaseAdminController
{
    /**
     * Display a listing of industries.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        readGate(PermissionEntityTypes::RESOURCE, 'industry', $this->admin);

        $perPage = $request->query('per_page', $this->perPage());

        $industries = Industry::searchQuery($request->all())
            ->orderBy('name')
            ->paginate($perPage)->appends(request()->except('page'));

        $pageTitle = 'Industries';

        return view('admin.career.industry.index', compact('industries', 'pageTitle'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new industry.
     *
     * @return View
     */
    public function create(): View
    {
        createGate(PermissionEntityTypes::RESOURCE, 'industry', $this->admin);

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
        createGate(PermissionEntityTypes::RESOURCE, 'industry', $this->admin);

        $industry = new Industry()->create($request->validated());

        return redirect()->route('admin.career.industry.show', $industry)
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
        readGate(PermissionEntityTypes::RESOURCE, $industry, $this->admin);

        list($prev, $next) = Industry::prevAndNextPages($industry->id,
            'admin.career.industry.show',
            null,
            ['name', 'asc']);

        return view('admin.career.industry.show', compact('industry', 'prev', 'next'));
    }

    /**
     * Show the form for editing the specified industry.
     *
     * @param Industry $industry
     * @return View
     */
    public function edit(Industry $industry): View
    {
        updateGate(PermissionEntityTypes::RESOURCE, $industry, $this->admin);

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
        $industry->update($request->validated());

        updateGate(PermissionEntityTypes::RESOURCE, $industry, $this->admin);

        return redirect()->route('admin.career.industry.show', $industry)
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
        deleteGate(PermissionEntityTypes::RESOURCE, $industry, $this->admin);

        $industry->delete();

        return redirect(referer('admin.career.industry.index'))
            ->with('success', $industry->name . ' deleted successfully.');
    }
}
