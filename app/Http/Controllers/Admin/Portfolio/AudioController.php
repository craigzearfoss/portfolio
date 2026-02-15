<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Enums\PermissionEntityTypes;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Middleware\Admin;
use App\Http\Requests\Portfolio\StoreAudiosRequest;
use App\Http\Requests\Portfolio\UpdateAudiosRequest;
use App\Models\Portfolio\Audio;
use App\Models\System\Owner;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
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
        readGate(PermissionEntityTypes::RESOURCE, 'audio', $this->admin);

        $perPage = $request->query('per_page', $this->perPage());

        $audios = Audio::searchQuery($request->all(), !empty($this->owner->root) ? null : $this->owner)
            ->orderBy('owner_id')
            ->orderBy('name')
            ->paginate($perPage)->appends(request()->except('page'));

        $pageTitle = ($this->isRootAdmin && !empty($owner_id)) ? $this->owner->name . ' Audio' : 'Audio';

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
        createGate(PermissionEntityTypes::RESOURCE, 'audio', $this->admin);

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
        createGate(PermissionEntityTypes::RESOURCE, 'audio', $this->admin);

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
        readGate(PermissionEntityTypes::RESOURCE, $audio, $this->admin);

        list($prev, $next) = Audio::prevAndNextPages($audio->id,
            'admin.portfolio.audio.show',
            $this->owner->id ?? null,
            ['name', 'asc']);

        return view('admin.portfolio.audio.show', compact('audio', 'prev', 'next'));
    }

    /**
     * Show the form for editing the specified audio.
     *
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $audio = new Audio()->findOrFail($id);

        updateGate(PermissionEntityTypes::RESOURCE, $audio, $this->admin);

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

        updateGate(PermissionEntityTypes::RESOURCE, $audio, $this->admin);

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
        deleteGate(PermissionEntityTypes::RESOURCE, $audio, $this->admin);

        $audio->delete();

        return redirect(referer('admin.portfolio.audio.index'))
            ->with('success', $audio->name . ' deleted successfully.');
    }
}
