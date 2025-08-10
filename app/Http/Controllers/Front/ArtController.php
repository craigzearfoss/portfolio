<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Portfolio\Art;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ArtController extends Controller
{
    const NUM_PER_PAGE = 20;

    /**
     * Display a listing of the art.
     */
    public function index(): View
    {
        $arts = Art::where('public', 1)
            ->where('disabled', 0)
            ->orderBy('sequence', 'asc')
            ->paginate(self::NUM_PER_PAGE);

        $title = 'Art';
        return view('front.art.index', compact('arts', 'title'))
            ->with('i', (request()->input('page', 1) - 1) * self::NUM_PER_PAGE);
    }

    /**
     * Display the specified art.
     */
    public function show(Art $art): View
    {
        return view('front.art.show', compact('art'));
    }
}
