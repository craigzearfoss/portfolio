<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Portfolio\StoreMusicRequest;
use App\Http\Requests\Portfolio\UpdateMusicRequest;
use App\Models\Portfolio\Art;
use App\Models\Portfolio\Music;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

/**
 *
 */
class MusicController extends BaseAdminController
{
    /**
     * Display a listing of music.
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
            $musics = Music::where('owner_id', $this->owner->id)->orderBy('name', 'asc')->paginate($perPage);
        } else {
            $musics = Music::orderBy('name', 'asc')->paginate($perPage);
        }

        $pageTitle = empty($this->owner) ? 'Music' : $this->owner->name . ' Music';

        return view('admin.portfolio.music.index', compact('musics'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new music.
     *
     * @return View
     */
    public function create(): View
    {
        return view('admin.portfolio.music.create');
    }

    /**
     * Store a newly created music in storage.
     *
     * @param StoreMusicRequest $request
     * @return RedirectResponse
     */
    public function store(StoreMusicRequest $request): RedirectResponse
    {
        $music = Music::create($request->validated());

        return redirect()->route('admin.portfolio.music.show', $music)
            ->with('success', $music->name . ' successfully added.');
    }

    /**
     * Display the specified music.
     *
     * @param Music $music
     * @return View
     */
    public function show(Music $music): View
    {
        list($prev, $next) = Music::prevAndNextPages($music->id,
            'admin.portfolio.music.show',
            $this->owner->id ?? null,
            ['name', 'asc']);

        return view('admin.portfolio.music.show', compact('music', 'prev', 'next'));
    }

    /**
     * Show the form for editing the specified music.
     *
     * @param Music $music
     * @return View
     */
    public function edit(Music $music): View
    {
        if (!isRootAdmin() && ($music->owner_id !== Auth::guard('admin')->user()->id)) {
            Abort(403, 'Not Authorized.');
        }
        //@TODO: Get authorization gate working.
        //Gate::authorize('update-resource', $music);

        return view('admin.portfolio.music.edit', compact('music'));
    }

    /**
     * Update the specified music in storage.
     *
     * @param UpdateMusicRequest $request
     * @param Music $music
     * @return RedirectResponse
     */
    public function update(UpdateMusicRequest $request, Music $music): RedirectResponse
    {
        $music->update($request->validated());

        return redirect()->route('admin.portfolio.music.show', $music)
            ->with('success', $music->name . ' successfully updated.');
    }

    /**
     * Remove the specified music from storage.
     *
     * @param Music $music
     * @return RedirectResponse
     */
    public function destroy(Music $music): RedirectResponse
    {
        if (!isRootAdmin() && ($music->owner_id !== Auth::guard('admin')->user()->id)) {
            Abort(403, 'Not Authorized.');
        }
        //@TODO: Get authorization gate working.
        //Gate::authorize('delete-resource', $music);

        $music->delete();

        return redirect(referer('admin.portfolio.music.index'))
            ->with('success', $music->name . ' deleted successfully.');
    }
}
