<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Portfolio\Art;
use App\Models\Portfolio\Music;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MusicController extends Controller
{
    const ROWS_PER_PAGE = 20;

    /**
     * Display a listing of the art.
     */
    public function index(): View
    {
        $musics = Music::where('public', 1)
            ->where('disabled', 0)
            ->orderBy('sequence', 'asc')
            ->paginate(self::ROWS_PER_PAGE);

        $title = 'Music';
        return view('front.music.index', compact('musics', 'title'))
            ->with('i', (request()->input('page', 1) - 1) * self::ROWS_PER_PAGE);
    }

    /**
     * Display the specified music.
     */
    public function show(Music $music): View
    {
        return view('music.show', compact('music'));
    }
}
