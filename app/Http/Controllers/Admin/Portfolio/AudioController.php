<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Portfolio\StoreAudiosRequest;
use App\Http\Requests\Portfolio\UpdateAudiosRequest;
use App\Models\Portfolio\Art;
use App\Models\Portfolio\Audio;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
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
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function index(Request $request): View
    {
        $perPage = $request->query('per_page', $this->perPage());

        if (!empty($this->owner)) {
            $audios = Audio::where('owner_id', $this->owner->id)->orderBy('name', 'asc')->paginate($perPage);
        } else {
            $audios = Audio::orderBy('name', 'asc')->paginate($perPage);
        }

        $pageTitle = empty($this->owner) ? 'Audio' : $this->owner->name . ' Audio';

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
        $audio = Audio::create($request->validated());

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
        list($prev, $next) = Audio::prevAndNextPages($audio->id,
            'admin.portfolio.audio.show',
            $this->owner->id ?? null,
            ['name', 'asc']);

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
        Gate::authorize('update-resource', $audio);

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
        Gate::authorize('update-resource', $audio);

        $audio->update($request->validated());

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
        Gate::authorize('delete-resource', $audio);

        $audio->delete();

        return redirect(referer('admin.portfolio.audio.index'))
            ->with('success', $audio->name . ' deleted successfully.');
    }
}
