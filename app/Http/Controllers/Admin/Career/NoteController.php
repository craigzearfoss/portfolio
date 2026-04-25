<?php

namespace App\Http\Controllers\Admin\Career;

use App\Exports\Career\NotesExport;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Career\StoreNotesRequest;
use App\Http\Requests\Career\UpdateNotesRequest;
use App\Models\Career\Application;
use App\Models\Career\Note;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Mockery\Matcher\Not;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

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
     * @throws Exception
     */
    public function index(Request $request): View
    {
        readGate(Note::class, $this->admin);

        $perPage = $request->query('per_page', $this->perPage());

        $notes = new Note()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', Note::SEARCH_ORDER_BY),
            $this->singleAdminMode || !$this->isRootAdmin ? $this->admin : null
        )
        ->paginate($perPage)->appends(request()->except('page'));

        $application = $request->application_id ? Application::query()->findOrFail($request->application_id) : null;

        $pageTitle = ($this->owner->name  ?? '') . ' Notes';

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
        createGate(Note::class, $this->admin);

        $application = !empty($request->application_id)
            ? Application::query()->find($request->application_id)
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
        createGate(Note::class, $this->admin);

        $applicationId = $request->query('application_id');

        if (!empty($applicationId) && (!$application = Application::query()->find($applicationId)))  {
            $previousUrl = url()->previous();
            $previousUrl = $previousUrl . '?' . http_build_query(['application_id' => $applicationId]);
            return redirect()->to($previousUrl)->with('error', 'Application `' . $applicationId . '` not found.')
                ->withInput();
        }

        $note = Note::query()->create($request->validated());

        if ($referer = $request->get('referer')) {
            return redirect($referer)->with('success', 'Note successfully added.');
        } elseif (!empty($application)) {
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
        readGate($note, $this->admin);

        list($prev, $next) = $note->prevAndNextPages(
            $note['id'],
            'admin.career.note.show',
            $this->owner ?? null,
            [ 'created_at', 'asc' ]
        );

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
        updateGate($note, $this->admin);

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

        if (!empty($applicationId) && (!$application = Application::query()->find($applicationId)))  {
            $previousUrl = url()->previous();
            $previousUrl = $previousUrl . '?' . http_build_query(['application_id' => $applicationId]);
            return redirect()->to($previousUrl)->with('error', 'Application `' . $applicationId . '` not found.')
                ->withInput();
        }

        $note->update($request->validated());

        updateGate($note, $this->admin);

        if ($referer = $request->get('referer')) {
            return redirect($referer)->with('success', 'Note successfully updated.');
        } elseif (!empty($application)) {
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
        deleteGate($note, $this->admin);

        $note->delete();

        return redirect(referer('admin.career.note.index'))
            ->with('success', 'Note deleted successfully.');
    }

    /**
     * @return BinaryFileResponse
     */
    public function export(): BinaryFileResponse
    {
        $filename = request()->has('timestamp')
            ? 'notes_' . date("Y-m-d-His") . '.xlsx'
            : 'notes.xlsx';

        return Excel::download(new NotesExport(), $filename);
    }
}
