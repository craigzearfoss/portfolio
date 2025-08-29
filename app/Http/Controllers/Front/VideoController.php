<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Portfolio\Video;
use Illuminate\View\View;

class VideoController extends Controller
{
    protected $numPerPage = 20;

    /**
     * Display a listing of the video.
     */
    public function index(): View
    {
        $videos = Video::where('public', 1)
            ->where('disabled', 0)
            ->orderBy('sequence', 'asc')
            ->paginate($this->numPerPage);

        $title = 'Videos';
        return view('front.video.index', compact('videos', 'title'))
            ->with('i', (request()->input('page', 1) - 1) * $this->numPerPage);
    }

    /**
     * Display the specified video.
     */
    public function show(Video $video): View
    {
        return view('front.video.show', compact('video'));
    }
}
