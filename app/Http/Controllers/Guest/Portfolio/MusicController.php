<?php

namespace App\Http\Controllers\Guest\Portfolio;

use App\Http\Controllers\Guest\BaseGuestController;
use App\Models\Portfolio\Music;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 *
 */
class MusicController extends BaseGuestController
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

        $musics = Music::where('public', 1)
            ->where('disabled', 0)
            ->orderBy('name', 'asc')->orderBy('artist', 'asc')
            ->paginate($perPage);

        $title = 'Music';
        return view('guest.portfolio.music.index', compact('musics', 'title'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Display the specified music.
     *
     * @param string $slug
     * @return View
     */
    public function show(string $slug): View
    {
        if (!$music = Music::where('slug', $slug)->first()) {
            throw new ModelNotFoundException();
        }

        return view('guest.portfolio.music.show', compact('music'));
    }
}
