<?php

namespace App\Http\Controllers\Admin\Career;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Career\StoreNotesRequest;
use App\Http\Requests\Career\UpdateNotesRequest;
use App\Models\Career\Application;
use App\Models\Career\Note;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 *
 */
class NoteController extends BaseAdminController
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

        $applicationId = $request->application_id;
        if (!empty($applicationId)) {
            $application = Application::find($applicationId);
            $notes = Note::where('application_id', $applicationId)->latest()->paginate($perPage);
        } else {
            $application = null;
            $notes = Note::latest()->paginate($perPage);
        }

        return view('admin.career.note.index', compact('notes', 'application'))
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
        $applicationId = $request->application_id;
        $application = !empty($applicationId)
            ? Application::find($applicationId)
            : null;

        return view('admin.career.note.create', compact('application'));
    }

    /**
     * Store a newly created note in storage.
     *
     * @param StoreNotesRequest $storeNotesRequest
     * @return RedirectResponse
     */
    public function store(StoreNotesRequest $storeNotesRequest): RedirectResponse
    {
        $note = Note::create($storeNotesRequest->validated());

        return redirect()->route('admin.career.note.show', $note)
            ->with('success', 'Note successfully added.');
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
     * @param UpdateNotesRequest $updateNotesRequest
     * @param Note $note
     * @return RedirectResponse
     */
    public function update(UpdateNotesRequest $updateNotesRequest, Note $note): RedirectResponse
    {
        $note->update($updateNotesRequest->validated());

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
