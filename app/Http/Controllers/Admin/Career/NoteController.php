<?php

namespace App\Http\Controllers\Admin\Career;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Career\StoreNoteRequest;
use App\Http\Requests\Career\UpdateNoteRequest;
use App\Models\Career\Note;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 *
 */
class NoteController extends BaseController
{
    /**
     * Display a listing of notes.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $perPage = $request->query('per_page', $this->perPage);

        $notes = Note::latest()->paginate($perPage);

        return view('admin.career.note.index', compact('notes'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new note.
     *
     * @return View
     */
    public function create(): View
    {
        return view('admin.career.note.create');
    }

    /**
     * Store a newly created note in storage.
     *
     * @param StoreNoteRequest $storeNoteRequest
     * @return RedirectResponse
     */
    public function store(StoreNoteRequest $storeNoteRequest): RedirectResponse
    {
        $note = Note::create($storeNoteRequest->validated());

        return redirect(referer('admin.career.note.index'))
            ->with('success', 'Note added successfully.');
    }

    /**
     * Display the specified note.
     *
     * @param Note $note
     * @return View
     */
    public function show(Note $note): View
    {
        return view('admin.career.note.show', compact('note'));
    }

    /**
     * Show the form for editing the specified note.
     *
     * @param Note $note
     * @return View
     */
    public function edit(Note $note): View
    {
        return view('admin.career.note.edit', compact('note'));
    }

    /**
     * Update the specified note in storage.
     *
     * @param UpdateNoteRequest $updateNoteRequest
     * @param Note $note
     * @return RedirectResponse
     */
    public function update(UpdateNoteRequest $updateNoteRequest, Note $note): RedirectResponse
    {
        $note->update($updateNoteRequest->validated());

        return redirect(referer('admin.career.note.index'))
            ->with('success', 'Note updated successfully.');
    }

    /**
     * Remove the specified note from storage.
     *
     * @param Note $note
     * @return RedirectResponse
     */
    public function destroy(Note $note): RedirectResponse
    {
        $note->delete();

        return redirect(referer('admin.career.note.index'))
            ->with('success', 'Note deleted successfully.');
    }
}
