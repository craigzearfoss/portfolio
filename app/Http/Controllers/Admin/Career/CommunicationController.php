<?php

namespace App\Http\Controllers\Admin\Career;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Career\CommunicationStoreRequest;
use App\Http\Requests\Career\CommunicationUpdateRequest;
use App\Models\Career\Communication;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 *
 */
class CommunicationController extends BaseController
{
    /**
     * Display a listing of communications.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $perPage = $request->query('per_page', $this->perPage);

        $communications = Communication::latest()->paginate($perPage);

        return view('admin.career.communication.index', compact('communications'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new communication.
     *
     * @return View
     */
    public function create(): View
    {
        return view('admin.career.communication.create');
    }

    /**
     * Store a newly created communication in storage.
     *
     * @param CommunicationStoreRequest $request
     * @return RedirectResponse
     */
    public function store(CommunicationStoreRequest $request): RedirectResponse
    {
        $communication = Communication::create($request->validated());

        return redirect(referer('admin.career.communication.index'))
            ->with('success', 'Communication added successfully.');
    }

    /**
     * Display the specified communication.
     *
     * @param Communication $communication
     * @return View
     */
    public function show(Communication $communication): View
    {
        return view('admin.career.communication.show', compact('communication'));
    }

    /**
     * Show the form for editing the specified communication.
     *
     * @param Communication $communication
     * @return View
     */
    public function edit(Communication $communication): View
    {
        return view('admin.career.communication.edit', compact('communication'));
    }

    /**
     * Update the specified communication in storage.
     *
     * @param CommunicationUpdateRequest $request
     * @param Communication $communication
     * @return RedirectResponse
     */
    public function update(CommunicationUpdateRequest $request, Communication $communication): RedirectResponse
    {
        $communication->update($request->validated());

        return redirect(referer('admin.career.communication.index'))
            ->with('success', 'Communication updated successfully.');
    }

    /**
     * Remove the specified communication from storage.
     *
     * @param Communication $communication
     * @return RedirectResponse
     */
    public function destroy(Communication $communication): RedirectResponse
    {
        $communication->delete();

        return redirect(referer('admin.career.communication.index'))
            ->with('success', 'Communication deleted successfully.');
    }
}
