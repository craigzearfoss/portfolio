<?php

namespace App\Http\Controllers\Admin\Career;

use App\Http\Controllers\Controller;
use App\Http\Requests\Career\CommunicationStoreRequest;
use App\Http\Requests\Career\CommunicationUpdateRequest;
use App\Models\Career\Communication;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CommunicationController extends Controller
{
    protected $numPerPage = 20;

    /**
     * Display a listing of communications.
     */
    public function index(): View
    {
        $communications = Communication::latest()->paginate($this->numPerPage);

        return view('admin.career.communication.index', compact('communications'))
            ->with('i', (request()->input('page', 1) - 1) * $this->numPerPage);
    }

    /**
     * Show the form for creating a new communication.
     */
    public function create(): View
    {
        return view('admin.career.communication.create');
    }

    /**
     * Store a newly created communication in storage.
     */
    public function store(CommunicationStoreRequest $request): RedirectResponse
    {
        Communication::create($request->validated());

        return redirect()->route('admin.career.communication.index')
            ->with('success', 'Communication created successfully.');
    }

    /**
     * Display the specified communication.
     */
    public function show(Communication $communication): View
    {
        return view('admin.career.communication.show', compact('communication'));
    }

    /**
     * Show the form for editing the specified communication.
     */
    public function edit(Communication $communication): View
    {
        return view('admin.career.communication.edit', compact('communication'));
    }

    /**
     * Update the specified communication in storage.
     */
    public function update(CommunicationUpdateRequest $request, Communication $communication): RedirectResponse
    {
        $communication->update($request->validated());

        return redirect()->route('admin.career.communication.index')
            ->with('success', 'Communication updated successfully');
    }

    /**
     * Remove the specified communication from storage.
     */
    public function destroy(Communication $communication): RedirectResponse
    {
        $communication->delete();

        return redirect()->route('admin.career.communication.index')
            ->with('success', 'Communication deleted successfully');
    }
}
