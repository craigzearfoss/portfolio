<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Http\Controllers\Controller;
use App\Http\Requests\Portfolio\MusicStoreRequest;
use App\Http\Requests\Portfolio\MusicUpdateRequest;
use App\Models\Portfolio\Music;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class MusicController extends Controller
{
    const PER_PAGE = 20;

    /**
     * Display a listing of music.
     */
    public function index(int $perPage = self::PER_PAGE): View
    {
        $musics = Music::latest()->paginate($perPage);

        return view('admin.portfolio.music.index', compact('musics'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new music.
     */
    public function create(): View
    {
        return view('admin.portfolio.music.create');
    }

    /**
     * Store a newly created music in storage.
     */
    public function store(MusicStoreRequest $request): RedirectResponse
    {
        Music::create($request->validated());

        return redirect()->route('admin.portfolio.music.index')
            ->with('success', 'Music created successfully.');
    }

    /**
     * Display the specified music.
     */
    public function show(Music $music): View
    {
        return view('admin.portfolio.music.show', compact('music'));
    }

    /**
     * Show the form for editing the specified music.
     */
    public function edit(Music $music): View
    {
        return view('admin.portfolio.music.edit', compact('music'));
    }

    /**
     * Update the specified music in storage.
     */
    public function update(MusicUpdateRequest $request, Music $music): RedirectResponse
    {
        dd($request);

        $music->update($request->validated());

        return redirect()->route('admin.portfolio.music.index')
            ->with('success', 'Music updated successfully');
    }

    /**
     * Remove the specified music from storage.
     */
    public function destroy(Music $music): RedirectResponse
    {
        $music->delete();

        return redirect()->route('admin.portfolio.music.index')
            ->with('success', 'Music deleted successfully');
    }
}
