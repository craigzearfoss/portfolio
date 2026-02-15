<?php

namespace App\Http\Controllers\Admin\Career;

use App\Enums\PermissionEntityTypes;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Career\StoreNotesRequest;
use App\Http\Requests\Career\UpdateNotesRequest;
use App\Models\Career\Application;
use App\Models\Career\Note;
use App\Models\System\Owner;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
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
        readGate(PermissionEntityTypes::RESOURCE, 'note', $this->admin);

        $perPage = $request->query('per_page', $this->perPage());

        $query = Note::searchQuery($request->all(), !empty($this->owner->root) ? null : $this->owner)
            ->orderBy('owner_id')
            ->orderBy('created_at', 'desc');
        if ($application = $request->application_id ? new Application()->findOrFail($request->application_id) : null) {
            $query->where('application_id', $application->id);
        }

        $notes = $query->paginate($perPage)->appends(request()->except('page'));

        $pageTitle = ($this->isRootAdmin && !empty($this->owner_id)) ? $this->owner->name . ' Notes' : 'Notes';

        return view('admin.career.note.index', compact('notes', 'application', 'pageTitle'))
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
        createGate(PermissionEntityTypes::RESOURCE, 'note', $this->admin);

        $application = !empty($request->application_id)
            ? new Application()->find($request->application_id)
            : null;

        return view('admin.career.note.create', compact('application'));
    }

    /**
     * Store a newly created note in storage.
     *
     * @param StoreNotesRequest $request
     * @return RedirectResponse
     */
    public function store(StoreNotesRequest $request): RedirectResponse
    {
        createGate(PermissionEntityTypes::RESOURCE, 'note', $this->admin);

        $applicationId = $request->query('application_id');

        if (!empty($applicationId) && (!$application = new Application()->find($applicationId)))  {
            $previousUrl = url()->previous();
            $previousUrl = $previousUrl . '?' . http_build_query(['application_id' => $applicationId]);
            return redirect()->to($previousUrl)->with('error', 'Application `' . $applicationId . '` not found.')
                ->withInput();
        }

        $note = new Note()->create($request->validated());

        if (!empty($application)) {
            return redirect()->route('admin.career.application.show', $application)
                ->with('success', 'Note successfully added.');

        } else {
            return redirect()->route('admin.career.note.show', $note)
                ->with('success', 'Note successfully added.');
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
        readGate(PermissionEntityTypes::RESOURCE, $note, $this->admin);

        list($prev, $next) = Note::prevAndNextPages($note->id,
            'admin.career.note.show',
            $this->owner->id ?? null,
            ['created_at', 'asc']);

        return view('admin.career.note.show', compact('note', 'prev', 'next'));
    }

    /**
     * Show the form for editing the specified note.
     *
     * @param Note $note
     * @return View
     */
    public function edit(Note $note): View
    {
        updateGate(PermissionEntityTypes::RESOURCE, $note, $this->admin);

        return view('admin.career.note.edit', compact('note'));
    }

    /**
     * Update the specified note in storage.
     *
     * @param UpdateNotesRequest $request
     * @param Note $note
     * @return RedirectResponse
     */
    public function update(UpdateNotesRequest $request, Note $note): RedirectResponse
    {
        $applicationId = $request->query('application_id');

        if (!empty($applicationId) && (!$application = new Application()->find($applicationId)))  {
            $previousUrl = url()->previous();
            $previousUrl = $previousUrl . '?' . http_build_query(['application_id' => $applicationId]);
            return redirect()->to($previousUrl)->with('error', 'Application `' . $applicationId . '` not found.')
                ->withInput();
        }

        $note->update($request->validated());

        updateGate(PermissionEntityTypes::RESOURCE, $note, $this->admin);

        if (!empty($application)) {
            return redirect()->route('admin.career.application.show', $application)
                ->with('success', 'Note successfully updated.');
        } else {
            return redirect()->route('admin.career.note.show', $note)
                ->with('success', 'Note successfully updated.');
        }
    }

    /**
     * Remove the specified note from storage.
     *
     * @param Note $note
     * @return RedirectResponse
     */
    public function destroy(Note $note): RedirectResponse
    {
        deleteGate(PermissionEntityTypes::RESOURCE, $note, $this->admin);

        $note->delete();

        return redirect(referer('admin.career.note.index'))
            ->with('success', 'Note deleted successfully.');
    }
}
