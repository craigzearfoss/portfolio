<?php

namespace App\Http\Controllers\Admin\Career;

use App\Http\Controllers\Controller;
use App\Http\Requests\Career\NoteStoreRequest;
use App\Http\Requests\Career\NoteUpdateRequest;
use App\Models\Career\Note;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class NoteController extends Controller
{
    protected $numPerPage = 20;

    /**
     * Display a listing of notes.
     */
    public function index(): View
    {
        $notes = Note::latest()->paginate($this->numPerPage);

        return view('admin.career.note.index', compact('notes'))
            ->with('i', (request()->input('page', 1) - 1) * $this->numPerPage);
    }

    /**
     * Show the form for creating a new note.
     */
    public function create(): View
    {
        return view('admin.career.note.create');
    }

    /**
     * Store a newly created note in storage.
     */
    public function store(NoteStoreRequest $request): RedirectResponse
    {
        Note::create($request->validated());

        return redirect()->route('admin.career.note.index')
            ->with('success', 'Note created successfully.');
    }

    /**
     * Display the specified note.
     */
    public function show(Note $note): View
    {
        return view('admin.career.note.show', compact('note'));
    }

    /**
     * Show the form for editing the specified note.
     */
    public function edit(Note $note): View
    {
        return view('admin.career.note.edit', compact('note'));
    }

    /**
     * Update the specified note in storage.
     */
    public function update(NoteUpdateRequest $request, Note $note): RedirectResponse
    {
        $note->update($request->validated());

        return redirect()->route('admin.career.note.index')
            ->with('success', 'Note updated successfully');
    }

    /**
     * Remove the specified note from storage.
     */
    public function destroy(Note $note): RedirectResponse
    {
        $note->delete();

        return redirect()->route('admin.career.note.index')
            ->with('success', 'Note deleted successfully');
    }
}
