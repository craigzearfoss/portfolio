<?php

namespace App\Http\Controllers\Admin\Career;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Career\ReferenceStoreRequest;
use App\Http\Requests\Career\ReferenceUpdateRequest;
use App\Models\Career\Reference;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

/**
 *
 */
class ReferenceController extends BaseController
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

        $references = Reference::latest()->paginate($perPage);

        return view('admin.career.reference.index', compact('references'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new reference.
     *
     * @param Request $request
     * @return View
     */
    public function create(Request $request): View
    {
        $referer = $request->headers->get('referer');

        return view('admin.career.reference.create', compact('referer'));
    }

    /**
     * Store a newly created reference in storage.
     *
     * @param ReferenceStoreRequest $request
     * @return RedirectResponse
     */
    public function store(ReferenceStoreRequest $request): RedirectResponse
    {
        $reference = Reference::create($request->validated());

        $referer = $request->input('referer');

        if (!empty($referer)) {
            return redirect(str_replace(config('app.url'), '', $referer))
                ->with('success', $reference->name . ' created successfully.');
        } else {
            return redirect()->route('admin.career.reference.index')
                ->with('success', $reference->name . ' created successfully.');
        }
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
     * @param Request $request
     * @return View
     */
    public function edit(Reference $reference): View
    {
        $referer = $request->headers->get('referer');

        return view('admin.career.reference.edit', compact('reference', 'referer'));
    }

    /**
     * Update the specified reference in storage.
     *
     * @param ReferenceUpdateRequest $request
     * @param Reference $reference
     * @return RedirectResponse
     */
    public function update(ReferenceUpdateRequest $request, Reference $reference): RedirectResponse
    {
        $reference->update($request->validated());

        $referer = $request->input('referer');

        if (!empty($referer)) {
            return redirect(str_replace(config('app.url'), '', $referer))
                ->with('success', $reference->name . ' updated successfully.');
        } else {
            return redirect()->route('admin.career.reference.index')
                ->with('success', $reference->name . ' updated successfully.');
        }
    }

    /**
     * Remove the specified reference from storage.
     *
     * @param Reference $reference
     * @param Request $request
     * @return RedirectResponse
     */
    public function destroy(Reference $reference, Request $request): RedirectResponse
    {
        $reference->delete();

        $referer = $request->input('referer');

        if (!empty($referer)) {
            return redirect(str_replace(config('app.url'), '', $referer))
                ->with('success', $reference->name . ' deleted successfully.');
        } else {
            return redirect()->route('admin.career.reference.index')
                ->with('success', $reference->name . ' deleted successfully.');
        }
    }
}
