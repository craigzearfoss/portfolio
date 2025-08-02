<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommunicationStoreRequest;
use App\Http\Requests\CommunicationUpdateRequest;
use App\Models\Career\Communication;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CommunicationController extends Controller
{
    const NUM_PER_PAGE = 20;

    /**
     * Display a listing of the communication.
     */
    public function index(): View
    {
        $communications = Communication::latest()->paginate(self::NUM_PER_PAGE);

        return view('admin.communication.index', compact('communications'))
            ->with('i', (request()->input('page', 1) - 1) * self::NUM_PER_PAGE);
    }

    /**
     * Show the form for creating a new communication.
     */
    public function create(): View
    {
        return view('admin.communication.create');
    }

    /**
     * Store a newly created communication in storage.
     */
    public function store(CommunicationStoreRequest $request): RedirectResponse
    {
        Communication::create($request->validated());

        return redirect()->route('admin.communication.index')
            ->with('success', 'Communication created successfully.');
    }

    /**
     * Display the specified communication.
     */
    public function show(Communication $communication): View
    {
        return view('admin.communication.show', compact('communication'));
    }

    /**
     * Show the form for editing the specified communication.
     */
    public function edit(Communication $communication): View
    {
        return view('admin.communication.edit', compact('communication'));
    }

    /**
     * Update the specified communication in storage.
     */
    public function update(CommunicationUpdateRequest $request, Communication $communication): RedirectResponse
    {
        $communication->update($request->validated());

        return redirect()->route('admin.communication.index')
            ->with('success', 'Communication updated successfully');
    }

    /**
     * Remove the specified communication from storage.
     */
    public function destroy(Communication $communication): RedirectResponse
    {
        $communication->delete();

        return redirect()->route('user.link.index')
            ->with('success', 'Communication deleted successfully');
    }
}
