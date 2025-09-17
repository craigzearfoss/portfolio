<?php

namespace App\Http\Controllers\Admin\Career;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Career\NoteStoreRequest;
use App\Http\Requests\Career\NoteUpdateRequest;
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
     * @param Request $request
     * @return View
     */
    public function create(Request $request): View
    {
        $referer = $request->headers->get('referer');

        return view('admin.career.note.create', compact('referer'));
    }

    /**
     * Store a newly created note in storage.
     *
     * @param NoteStoreRequest $request
     * @return RedirectResponse
     */
    public function store(NoteStoreRequest $request): RedirectResponse
    {
        $note = Note::create($request->validated());

        $referer = $request->headers->get('referer');

        if (!empty($referer)) {
            return redirect(str_replace(config('app.url'), '', $referer))
                ->with('success', 'Note created successfully.');
        } else {
            return redirect()->route('admin.career.application.index')
                ->with('success', 'Note created successfully.');
        }
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
     * @param Request $request
     * @return View
     */
    public function edit(Note $note): View
    {
        $referer = $request->headers->get('referer');

        return view('admin.career.note.edit', compact('note', 'referer'));
    }

    /**
     * Update the specified note in storage.
     *
     * @param NoteUpdateRequest $request
     * @param Note $note
     * @return RedirectResponse
     */
    public function update(NoteUpdateRequest $request, Note $note): RedirectResponse
    {
        $note->update($request->validated());

        $referer = $request->input('referer');

        if (!empty($referer)) {
            return redirect(str_replace(config('app.url'), '', $referer))
                ->with('success', 'Note updated successfully.');
        } else {
            return redirect()->route('admin.career.application.index')
                ->with('success', 'Note updated successfully.');
        }
    }

    /**
     * Remove the specified note from storage.
     *
     * @param Note $note
     * @param Request $request
     * @return RedirectResponse
     */
    public function destroy(Note $note, Request $request): RedirectResponse
    {
        $note->delete();

        $referer = $request->input('referer');

        if (!empty($referer)) {
            return redirect(str_replace(config('app.url'), '', $referer))
                ->with('success', 'Note deleted successfully.');
        } else {
            return redirect()->route('admin.dictionary.database.index')
                ->with('success', 'Note deleted successfully.');
        }
    }
}
