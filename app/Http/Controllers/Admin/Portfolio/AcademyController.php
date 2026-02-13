<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Enums\PermissionEntityTypes;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Portfolio\StoreAcademiesRequest;
use App\Http\Requests\Portfolio\UpdateAcademiesRequest;
use App\Models\Portfolio\Academy;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

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
        readGate(PermissionEntityTypes::RESOURCE, 'academy', $this->admin);

        $perPage = $request->query('per_page', $this->perPage());

        $academies = Academy::searchQuery($request->all())
            ->where('name', '!=', 'other')->orderBy('name', 'asc')
            ->orderBy('name', 'asc')
            ->paginate($perPage)->appends(request()->except('page'));

        $pageTitle = 'Academies';

        return view('admin.portfolio.academy.index', compact('academies', 'pageTitle'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new academy.
     *
     * @return View
     */
    public function create(): View
    {
        createGate(PermissionEntityTypes::RESOURCE, 'academy', $this->admin);

        return view('admin.portfolio.academy.create');
    }

    /**
     * Store a newly created academy in storage.
     *
     * @param StoreAcademiesRequest $request
     * @return RedirectResponse
     */
    public function store(StoreAcademiesRequest $request): RedirectResponse
    {
        createGate(PermissionEntityTypes::RESOURCE, 'academy', $this->admin);

        $academy = Academy::create($request->validated());

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
        readGate(PermissionEntityTypes::RESOURCE, $academy, $this->admin);

        list($prev, $next) = Academy::prevAndNextPages($academy->id,
            'admin.portfolio.academy.show',
            null,
            ['name', 'asc']);

        return view('admin.portfolio.academy.show', compact('academy', 'prev', 'next'));
    }

    /**
     * Show the form for editing the specified academy.
     *
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $academy = Academy::findOrFail($id);

        updateGate(PermissionEntityTypes::RESOURCE, $academy, $this->admin);

        return view('admin.portfolio.academy.edit', compact('academy'));
    }

    /**
     * Update the specified academy in storage.
     *
     * @param UpdateAcademiesRequest $request
     * @param Academy $academy
     * @return RedirectResponse
     */
    public function update(UpdateAcademiesRequest $request, Academy $academy): RedirectResponse
    {
        $academy->update($request->validated());

        updateGate(PermissionEntityTypes::RESOURCE, $academy, $this->admin);

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
        deleteGate(PermissionEntityTypes::RESOURCE, $academy, $this->admin);

        $academy->delete();

        return redirect(route('admin.portfolio.academy.index'))
            ->with('success', $academy->name . ' deleted successfully.');
    }
}
