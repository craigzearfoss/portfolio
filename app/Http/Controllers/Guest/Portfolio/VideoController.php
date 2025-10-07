<?php

namespace App\Http\Controllers\Guest\Portfolio;

use App\Http\Controllers\BaseController;
use App\Models\Portfolio\Video;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 *
 */
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
            ->orderBy('name', 'asc')
            ->paginate($perPage);

        $title = 'Videos';
        return view('guest.portfolio.video.index', compact('videos', 'title'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Display the specified video.
     *
     * @param string $slug
     * @return View
     */
    public function show(string $slug): View
    {
        if (!$video = Video::where('slug', $slug)->first()) {
            throw new ModelNotFoundException();
        }

        return view('guest.portfolio.video.show', compact('video'));
    }
}
