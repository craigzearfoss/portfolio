<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Portfolio\MusicStoreRequest;
use App\Http\Requests\Portfolio\MusicUpdateRequest;
use App\Models\Portfolio\Music;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

/**
 *
 */
class MusicController extends BaseController
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
     * @param MusicStoreRequest $request
     * @return RedirectResponse
     */
    public function store(MusicStoreRequest $request): RedirectResponse
    {
        $music = Music::create($request->validated());

        return redirect(referer('admin.portfolio.music.index'))
            ->with('success', $music->name . ' created successfully.');
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
        return view('admin.portfolio.music.edit', compact('music'));
    }

    /**
     * Update the specified music in storage.
     *
     * @param MusicUpdateRequest $request
     * @param Music $music
     * @return RedirectResponse
     */
    public function update(MusicUpdateRequest $request, Music $music): RedirectResponse
    {
        $music->update($request->validated());

        return redirect(referer('admin.portfolio.music.index'))
            ->with('success', $music->name . ' updated successfully.');
    }

    /**
     * Remove the specified music from storage.
     *
     * @param Music $music
     * @return RedirectResponse
     */
    public function destroy(Music $music): RedirectResponse
    {
        $music->delete();

        return redirect(referer('admin.portfolio.music.index'))
            ->with('success', $music->name . ' deleted successfully.');
    }
}
