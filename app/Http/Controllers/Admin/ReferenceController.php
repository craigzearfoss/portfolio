<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CareerReferenceStoreRequest;
use App\Http\Requests\CareerReferenceUpdateRequest;
use App\Models\Career\Reference;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReferenceController extends Controller
{
    const NUM_PER_PAGE = 20;

    /**
     * Display a listing of the reference.
     */
    public function index(): View
    {
        $references = Reference::latest()->paginate(self::NUM_PER_PAGE);

        return view('admin.reference.index', compact('references'))
            ->with('i', (request()->input('page', 1) - 1) * self::NUM_PER_PAGE);
    }

    /**
     * Show the form for creating a new reference.
     */
    public function create(): View
    {
        return view('admin.reference.create');
    }

    /**
     * Store a newly created reference in storage.
     */
    public function store(CareerReferenceStoreRequest $request): RedirectResponse
    {
        Reference::create($request->validated());

        return redirect()->route('admin.reference.index')
            ->with('success', 'Reference created successfully.');
    }

    /**
     * Display the specified reference.
     */
    public function show(Reference $reference): View
    {
        return view('admin.reference.show', compact('reference'));
    }

    /**
     * Show the form for editing the specified reference.
     */
    public function edit(Reference $reference): View
    {
        return view('admin.reference.edit', compact('reference'));
    }

    /**
     * Update the specified reference in storage.
     */
    public function update(CareerReferenceUpdateRequest $request, Reference $reference): RedirectResponse
    {
        dd($request);

        $reference->update($request->validated());

        return redirect()->route('admin.reference.index')
            ->with('success', 'Reference updated successfully');
    }

    /**
     * Remove the specified reference from storage.
     */
    public function destroy(Reference $reference): RedirectResponse
    {
        $reference->delete();

        return redirect()->route('admin.reference.index')
            ->with('success', 'Reference deleted successfully');
    }
}
