<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Portfolio\StoreMusicRequest;
use App\Http\Requests\Portfolio\UpdateMusicRequest;
use App\Models\Portfolio\Music;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
     */
    public function index(Request $request): View
    {
        readGate(Music::class, $this->admin);

        $perPage = $request->query('per_page', $this->perPage());

        // by default, root admins display all music
        $owner = ($this->owner && ($this->owner['id'] !== $this->admin['id'])) ? $this->owner : null;

        $musics = new Music()->searchQuery(request()->except('id'), $owner)
            ->orderBy('owner_id')
            ->orderBy('name')
            ->paginate($perPage)->appends(request()->except('page'));

        $pageTitle = ($owner->name  ?? '') . ' Music';

        return view('admin.portfolio.music.index', compact('musics', 'pageTitle'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new music.
     *
     * @return View
     */
    public function create(): View
    {
        createGate(Music::class, $this->admin);

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
        createGate(Music::class, $this->admin);

        $music = new Music()->create($request->validated());

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
        readGate($music, $this->admin);

        list($prev, $next) = $music->prevAndNextPages(
            $music['id'],
            'admin.portfolio.music.show',
            $this->owner ?? null,
            [ 'name', 'asc' ]
        );

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
        updateGate($music, $this->admin);

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

        updateGate($music, $this->admin);

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
        deleteGate($music, $this->admin);

        $music->delete();

        return redirect(referer('admin.portfolio.music.index'))
            ->with('success', $music->name . ' deleted successfully.');
    }
}
