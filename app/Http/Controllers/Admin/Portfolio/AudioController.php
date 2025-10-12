<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Portfolio\StoreAudiosRequest;
use App\Http\Requests\Portfolio\UpdateAudiosRequest;
use App\Models\Portfolio\Audio;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

/**
 *
 */
class AudioController extends BaseAdminController
{
    /**
     * Display a listing of audios.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $perPage = $request->query('per_page', $this->perPage);

        $audios = Audio::orderBy('name', 'asc')->paginate($perPage);

        return view('admin.portfolio.audio.index', compact('audios'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new audio.
     *
     * @return View
     */
    public function create(): View
    {
        return view('admin.portfolio.audio.create');
    }

    /**
     * Store a newly created audio in storage.
     *
     * @param StoreAudiosRequest $storeAudioRequest
     * @return RedirectResponse
     */
    public function store(StoreAudiosRequest $storeAudioRequest): RedirectResponse
    {
        $audio = Audio::create($storeAudioRequest->validated());

        return redirect(referer('admin.portfolio.audio.index'))
            ->with('success', $audio->name . ' added successfully.');
    }

    /**
     * Display the specified audio.
     *
     * @param Audio $audio
     * @return View
     */
    public function show(Audio $audio): View
    {
        return view('admin.portfolio.audio.show', compact('audio'));
    }

    /**
     * Show the form for editing the specified audio.
     *
     * @param Audio $audio
     * @return View
     */
    public function edit(Audio $audio): View
    {
        return view('admin.portfolio.audio.edit', compact('audio'));
    }

    /**
     * Update the specified audio in storage.
     *
     * @param UpdateAudiosRequest $updateAudioRequest
     * @param Audio $audio
     * @return RedirectResponse
     */
    public function update(UpdateAudiosRequest $updateAudioRequest, Audio $audio): RedirectResponse
    {
        $audio->update($updateAudioRequest->validated());

        return redirect(referer('admin.portfolio.audio.index'))
            ->with('success', $audio->name . ' updated successfully.');
    }

    /**
     * Remove the specified audio from storage.
     *
     * @param Audio $audio
     * @return RedirectResponse
     */
    public function destroy(Audio $audio): RedirectResponse
    {
        $audio->delete();

        return redirect(referer('admin.portfolio.audio.index'))
            ->with('success', $audio->name . ' deleted successfully.');
    }
}
