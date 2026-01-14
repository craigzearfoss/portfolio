<?php

namespace App\Http\Controllers\Admin\Root\Career;

use App\Http\Controllers\Admin\Root\BaseAdminRootController;
use App\Http\Requests\Career\StoreReferencesRequest;
use App\Http\Requests\Career\UpdateReferencesRequest;
use App\Models\Career\Reference;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

/**
 *
 */
class ReferenceController extends BaseAdminRootController
{
    /**
     * Display a listing of references.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $perPage = $request->query('per_page', $this->perPage);

        $references = Reference::orderBy('name', 'asc')->paginate($perPage);

        return view('admin.career.reference.index', compact('references'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new reference.
     *
     * @return View
     */
    public function create(): View
    {
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
        $reference = Reference::create($request->validated());

        return redirect()->route('root.career.reference.show', $reference)
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
        return view('admin.career.reference.show', compact('reference'));
    }

    /**
     * Show the form for editing the specified reference.
     *
     * @param Reference $reference
     * @return View
     */
    public function edit(Reference $reference): View
    {
        Gate::authorize('update-resource', $reference);

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
        Gate::authorize('update-resource', $reference);

        $reference->update($request->validated());

        return redirect()->route('root.career.reference.show', $reference)
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
        Gate::authorize('delete-resource', $reference);

        $reference->delete();

        return redirect(referer('root.career.reference.index'))
            ->with('success', $reference->name . ' deleted successfully.');
    }
}
