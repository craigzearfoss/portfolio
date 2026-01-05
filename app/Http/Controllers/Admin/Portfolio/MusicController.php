<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Portfolio\StoreMusicRequest;
use App\Http\Requests\Portfolio\UpdateMusicRequest;
use App\Models\Portfolio\Music;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
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
        $perPage = $request->query('per_page', $this->perPage);

        $musics = Music::orderBy('name', 'asc')->paginate($perPage);

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
        return view('admin.portfolio.music.show', compact('music'));
    }

    /**
     * Show the form for editing the specified music.
     *
     * @param Music $music
     * @return View
     */
    public function edit(Music $music): View
    {
        Gate::authorize('update-resource', $music);

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
        Gate::authorize('update-resource', $music);

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
        Gate::authorize('delete-resource', $music);

        $music->delete();

        return redirect(referer('admin.portfolio.music.index'))
            ->with('success', $music->name . ' deleted successfully.');
    }
}
