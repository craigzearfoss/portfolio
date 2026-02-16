<?php

namespace App\Http\Controllers\Admin\Career;

use App\Enums\PermissionEntityTypes;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Career\StoreReferencesRequest;
use App\Http\Requests\Career\UpdateReferencesRequest;
use App\Models\Career\Reference;
use App\Models\System\Owner;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

/**
 *
 */
class ReferenceController extends BaseAdminController
{
    /**
     * Display a listing of references.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        readGate(PermissionEntityTypes::RESOURCE, 'reference', $this->admin);

        $perPage = $request->query('per_page', $this->perPage());

        $references = Reference::searchQuery($request->all(), !empty($this->owner->root) ? null : $this->owner)
            ->orderBy('owner_id')
            ->orderBy('name')
            ->paginate($perPage)->appends(request()->except('page'));

        $pageTitle = ($this->isRootAdmin && !empty($owner_id)) ? $this->owner->name . ' References' : 'References';

        return view('admin.career.reference.index', compact('references', 'pageTitle'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new reference.
     *
     * @return View
     */
    public function create(): View
    {
        createGate(PermissionEntityTypes::RESOURCE, 'reference', $this->admin);

        return view('admin.career.reference.create');
    }

    /**
     * Store a newly created reference in storage.
     *
     * @param StoreReferencesRequest $request
     * @return RedirectResponse
     */
    public function store(StoreReferencesRequest $request): RedirectResponse
    {
        createGate(PermissionEntityTypes::RESOURCE, 'reference', $this->admin);

        $reference = new Reference()->create($request->validated());

        return redirect()->route('admin.career.reference.show', $reference)
            ->with('success', $reference->name . ' successfully added.');
    }

    /**
     * Display the specified reference.
     *
     * @param Reference $reference
     * @return View
     */
    public function show(Reference $reference): View
    {
        readGate(PermissionEntityTypes::RESOURCE, $reference, $this->admin);

        list($prev, $next) = Reference::prevAndNextPages($reference->id,
            'admin.career.reference.show',
            $this->owner->id ?? null,
            ['name', 'asc']);

        return view('admin.career.reference.show', compact('reference', 'prev', 'next'));
    }

    /**
     * Show the form for editing the specified reference.
     *
     * @param Reference $reference
     * @return View
     */
    public function edit(Reference $reference): View
    {
        updateGate(PermissionEntityTypes::RESOURCE, $reference, $this->admin);

        return view('admin.career.reference.edit', compact('reference'));
    }

    /**
     * Update the specified reference in storage.
     *
     * @param UpdateReferencesRequest $request
     * @param Reference $reference
     * @return RedirectResponse
     */
    public function update(UpdateReferencesRequest $request, Reference $reference): RedirectResponse
    {
        $reference->update($request->validated());

        updateGate(PermissionEntityTypes::RESOURCE, $reference, $this->admin);

        return redirect()->route('admin.career.reference.show', $reference)
            ->with('success', $reference->name . ' successfully updated.');
    }

    /**
     * Remove the specified reference from storage.
     *
     * @param Reference $reference
     * @return RedirectResponse
     */
    public function destroy(Reference $reference): RedirectResponse
    {
        deleteGate(PermissionEntityTypes::RESOURCE, $reference, $this->admin);

        $reference->delete();

        return redirect(referer('admin.career.reference.index'))
            ->with('success', $reference->name . ' deleted successfully.');
    }
}
