<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Http\Controllers\Controller;
use App\Http\Requests\PortfolioMusicStoreRequest;
use App\Http\Requests\PortfolioMusicUpdateRequest;
use App\Models\Portfolio\Music;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class MusicController extends Controller
{
    const NUM_PER_PAGE = 20;

    /**
     * Display a listing of music.
     */
    public function index(): View
    {
        $musics = Music::latest()->paginate(self::NUM_PER_PAGE);

        return view('admin.music.index', compact('musics'))
            ->with('i', (request()->input('page', 1) - 1) * self::NUM_PER_PAGE);
    }

    /**
     * Show the form for creating a new music.
     */
    public function create(): View
    {
        return view('admin.music.create');
    }

    /**
     * Store a newly created music in storage.
     */
    public function store(PortfolioMusicStoreRequest $request): RedirectResponse
    {
        Music::create($request->validated());

        return redirect()->route('admin.music.index')
            ->with('success', 'Music created successfully.');
    }

    /**
     * Display the specified music.
     */
    public function show(Music $music): View
    {
        return view('admin.music.show', compact('music'));
    }

    /**
     * Show the form for editing the specified music.
     */
    public function edit(Music $music): View
    {
        return view('admin.music.edit', compact('music'));
    }

    /**
     * Update the specified music in storage.
     */
    public function update(PortfolioMusicUpdateRequest $request, Music $music): RedirectResponse
    {
        dd($request);

        $music->update($request->validated());

        return redirect()->route('admin.music.index')
            ->with('success', 'Music updated successfully');
    }

    /**
     * Remove the specified music from storage.
     */
    public function destroy(Music $music): RedirectResponse
    {
        $music->delete();

        return redirect()->route('admin.music.index')
            ->with('success', 'Music deleted successfully');
    }
}
