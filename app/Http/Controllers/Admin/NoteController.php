<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CareerNoteStoreRequest;
use App\Http\Requests\CareerNoteUpdateRequest;
use App\Models\Career\Note;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class NoteController extends Controller
{
    const NUM_PER_PAGE = 20;

    /**
     * Display a listing of the note.
     */
    public function index(): View
    {
        $notes = Note::latest()->paginate(self::NUM_PER_PAGE);

        return view('admin.note.index', compact('notes'))
            ->with('i', (request()->input('page', 1) - 1) * self::NUM_PER_PAGE);
    }

    /**
     * Show the form for creating a new note.
     */
    public function create(): View
    {
        return view('admin.note.create');
    }

    /**
     * Store a newly created note in storage.
     */
    public function store(CareerNoteStoreRequest $request): RedirectResponse
    {
        Note::create($request->validated());

        return redirect()->route('admin.note.index')
            ->with('success', 'Note created successfully.');
    }

    /**
     * Display the specified note.
     */
    public function show(Note $note): View
    {
        return view('admin.note.show', compact('note'));
    }

    /**
     * Show the form for editing the specified note.
     */
    public function edit(Note $note): View
    {
        return view('admin.note.edit', compact('note'));
    }

    /**
     * Update the specified note in storage.
     */
    public function update(CareerNoteUpdateRequest $request, Note $note): RedirectResponse
    {
        $note->update($request->validated());

        return redirect()->route('admin.note.index')
            ->with('success', 'Note updated successfully');
    }

    /**
     * Remove the specified note from storage.
     */
    public function destroy(Note $note): RedirectResponse
    {
        $note->delete();

        return redirect()->route('user.link.index')
            ->with('success', 'Note deleted successfully');
    }
}
