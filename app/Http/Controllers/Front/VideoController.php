<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Portfolio\Video;
use Illuminate\View\View;

class VideoController extends Controller
{
    const NUM_PER_PAGE = 20;

    /**
     * Display a listing of the video.
     */
    public function index(): View
    {
        $videos = Video::where('disabled', 0)->orderBy('seq')->paginate(self::NUM_PER_PAGE);

        $title = 'Videos';
        return view('front.video.index', compact('videos', 'title'))
            ->with('i', (request()->input('page', 1) - 1) * self::NUM_PER_PAGE);
    }
}
