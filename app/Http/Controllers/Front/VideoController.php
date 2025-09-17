<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\BaseController;
use App\Models\Portfolio\Video;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VideoController extends BaseController
{
    /**
     * Display a listing of videos.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $perPage = $request->query('per_page', $this->perPage);

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
