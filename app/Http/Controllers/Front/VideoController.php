<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Portfolio\Video;
use Illuminate\View\View;

class VideoController extends Controller
{
    const ROWS_PER_PAGE = 20;

    /**
     * Display a listing of the video.
     */
    public function index(): View
    {
        $videos = Video::where('public', 1)
            ->where('disabled', 0)
            ->orderBy('sequence', 'asc')
            ->paginate(self::ROWS_PER_PAGE);

        $title = 'Videos';
        return view('front.video.index', compact('videos', 'title'))
            ->with('i', (request()->input('page', 1) - 1) * self::ROWS_PER_PAGE);
    }

    /**
     * Display the specified video.
     */
    public function show(Video $video): View
    {
        return view('front.video.show', compact('video'));
    }
}
