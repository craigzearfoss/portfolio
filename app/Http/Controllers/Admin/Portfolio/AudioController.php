<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Portfolio\StoreAudiosRequest;
use App\Http\Requests\Portfolio\UpdateAudiosRequest;
use App\Models\Portfolio\Audio;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 *
 */
class AudioController extends BaseAdminController
{
    /**
     * Display a listing of audio.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        readGate(Audio::class, $this->admin);

        $perPage = $request->query('per_page', $this->perPage());

        // by default, root admins display all audio
        $owner = ($this->owner && ($this->owner['id'] !== $this->admin['id'])) ? $this->owner : null;

        $audios = new Audio()->searchQuery(request()->except('id'), $owner)
            ->orderBy('owner_id')
            ->orderBy('name')
            ->paginate($perPage)->appends(request()->except('page'));

        $pageTitle = ($owner->name  ?? '') . ' audio';

        return view('admin.portfolio.audio.index', compact('audios','pageTitle'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new audio.
     *
     * @return View
     */
    public function create(): View
    {
        createGate(Audio::class, $this->admin);

        return view('admin.portfolio.audio.create');
    }

    /**
     * Store a newly created audio in storage.
     *
     * @param StoreAudiosRequest $request
     * @return RedirectResponse
     */
    public function store(StoreAudiosRequest $request): RedirectResponse
    {
        createGate(Audio::class, $this->admin);

        $audio = new Audio()->create($request->validated());

        return redirect()->route('admin.portfolio.audio.show', $audio)
            ->with('success', $audio->name . ' successfully added.');
    }

    /**
     * Display the specified audio.
     *
     * @param Audio $audio
     * @return View
     */
    public function show(Audio $audio): View
    {
        readGate($audio, $this->admin);

        list($prev, $next) = $audio->prevAndNextPages(
            $audio['id'],
            'admin.portfolio.audio.show',
            $this->owner ?? null,
            [ 'name', 'asc' ]
        );

        return view('admin.portfolio.audio.show', compact('audio', 'prev', 'next'));
    }

    /**
     * Show the form for editing the specified audio.
     *
     * @param Audio $audio
     * @return View
     */
    public function edit(Audio $audio): View
    {
        updateGate($audio, $this->admin);

        return view('admin.portfolio.audio.edit', compact('audio'));
    }

    /**
     * Update the specified audio in storage.
     *
     * @param UpdateAudiosRequest $request
     * @param Audio $audio
     * @return RedirectResponse
     */
    public function update(UpdateAudiosRequest $request, Audio $audio): RedirectResponse
    {
        $audio->update($request->validated());

        updateGate($audio, $this->admin);

        return redirect()->route('admin.portfolio.audio.show', $audio)
            ->with('success', $audio->name . ' successfully updated.');
    }

    /**
     * Remove the specified audio from storage.
     *
     * @param Audio $audio
     * @return RedirectResponse
     */
    public function destroy(Audio $audio): RedirectResponse
    {
        deleteGate($audio, $this->admin);

        $audio->delete();

        return redirect(referer('admin.portfolio.audio.index'))
            ->with('success', $audio->name . ' deleted successfully.');
    }
}
