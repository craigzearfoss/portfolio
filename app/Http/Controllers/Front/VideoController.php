<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Portfolio\Video;
use Illuminate\View\View;

class VideoController extends Controller
{
    const PER_PAGE = 20;

    /**
     * Display a listing of the video.
     */
    public function index(int $perPage = self::PER_PAGE): View
    {
        $videos = Video::where('public', 1)
            ->where('disabled', 0)
            ->orderBy('sequence', 'asc')
            ->paginate($perPage);

        $title = 'Videos';
        return view('front.video.index', compact('videos', 'title'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Display the specified video.
     */
    public function show(Video $video): View
    {
        return view('front.video.show', compact('video'));
    }
}
