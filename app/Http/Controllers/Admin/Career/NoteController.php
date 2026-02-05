<?php

namespace App\Http\Controllers\Admin\Career;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Career\StoreNotesRequest;
use App\Http\Requests\Career\UpdateNotesRequest;
use App\Models\Career\Application;
use App\Models\Career\Note;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
        $perPage = $request->query('per_page', $this->perPage());

        $applicationId = $request->application_id;
        if (!empty($applicationId)) {

            $application = Application::find($applicationId);
            $notes = Note::where('application_id', $applicationId)->latest()->paginate($perPage);

        } else {

            $application = null;
            if (!empty($this->owner)) {
                $notes = Note::where('owner_id', $this->owner->id)->latest()->paginate($perPage);
            } else {
                $notes = Note::latest()->paginate($perPage);
            }
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
        $urlParams = [];
        $application = null;
        if ($applicationId = $request->get('application_id')) {
            $urlParams['application_id'] = $applicationId;
            $application = Application::find($applicationId);
        }

        return view('admin.career.note.create', compact('application', 'urlParams'));
    }

    /**
     * Store a newly created note in storage.
     *
     * @param StoreNotesRequest $request
     * @return RedirectResponse
     */
    public function store(StoreNotesRequest $request): RedirectResponse
    {
        $applicationId = $request->query('application_id');

        if (!empty($applicationId) && (!$application = Application::find($applicationId)))  {
            $previousUrl = url()->previous();
            if ($applicationId) {
                $previousUrl = $previousUrl . '?' . http_build_query(['application_id' => $applicationId]);
            }
            return redirect()->to($previousUrl)->with('error', 'Application `' . $applicationId . '` not found.')
                ->withInput();
        }

        $note = Note::create($request->validated());

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
     * @param Request $request
     * @return View
     */
    public function edit(Note $note, Request $request): View
    {
        if (!isRootAdmin() && ($note->owner_id !== Auth::guard('admin')->user()->id)) {
            Abort(403, 'Not Authorized.');
        }
        //@TODO: Get authorization gate working.
        //Gate::authorize('update-resource', $note);

        $urlParams = [];
        if ($applicationId = $request->get('application_id')) {
            $urlParams['application_id'] = $applicationId;
        }

        return view('admin.career.note.edit', compact('note', 'urlParams'));
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

        if (!empty($applicationId) && (!$application = Application::find($applicationId)))  {
            $previousUrl = url()->previous();
            if ($applicationId) {
                $previousUrl = $previousUrl . '?' . http_build_query(['application_id' => $applicationId]);
            }
            return redirect()->to($previousUrl)->with('error', 'Application `' . $applicationId . '` not found.')
                ->withInput();
        }

        $note->update($request->validated());

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
        if (!isRootAdmin() && ($note->owner_id !== Auth::guard('admin')->user()->id)) {
            Abort(403, 'Not Authorized.');
        }
        //@TODO: Get authorization gate working.
        //Gate::authorize('delete-resource', $note);

        $note->delete();

        return redirect(referer('admin.career.note.index'))
            ->with('success', 'Note deleted successfully.');
    }
}
