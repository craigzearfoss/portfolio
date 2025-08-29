<?php

namespace App\Http\Controllers\Admin\Career;

use App\Http\Controllers\Controller;
use App\Http\Requests\Career\ReferenceStoreRequest;
use App\Http\Requests\Career\ReferenceUpdateRequest;
use App\Models\Career\Reference;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ReferenceController extends Controller
{
    protected $numPerPage = 20;

    /**
     * Display a listing of references.
     */
    public function index(): View
    {
        $references = Reference::latest()->paginate($this->numPerPage);

        return view('admin.career.reference.index', compact('references'))
            ->with('i', (request()->input('page', 1) - 1) * $this->numPerPage);
    }

    /**
     * Show the form for creating a new reference.
     */
    public function create(): View
    {
        return view('admin.career.reference.create');
    }

    /**
     * Store a newly created reference in storage.
     */
    public function store(ReferenceStoreRequest $request): RedirectResponse
    {
        Reference::create($request->validated());

        return redirect()->route('admin.career.reference.index')
            ->with('success', 'Reference created successfully.');
    }

    /**
     * Display the specified reference.
     */
    public function show(Reference $reference): View
    {
        return view('admin.career.reference.show', compact('reference'));
    }

    /**
     * Show the form for editing the specified reference.
     */
    public function edit(Reference $reference): View
    {
        return view('admin.career.reference.edit', compact('reference'));
    }

    /**
     * Update the specified reference in storage.
     */
    public function update(ReferenceUpdateRequest $request, Reference $reference): RedirectResponse
    {
        dd($request);

        $reference->update($request->validated());

        return redirect()->route('admin.career.reference.index')
            ->with('success', 'Reference updated successfully');
    }

    /**
     * Remove the specified reference from storage.
     */
    public function destroy(Reference $reference): RedirectResponse
    {
        $reference->delete();

        return redirect()->route('admin.career.reference.index')
            ->with('success', 'Reference deleted successfully');
    }
}
