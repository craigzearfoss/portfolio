<?php

namespace App\Http\Controllers\Guest\Portfolio;

use App\Http\Controllers\Guest\BaseGuestController;
use App\Models\Portfolio\Video;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 *
 */
class VideoController extends BaseGuestController
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

        return view(themedTemplate('guest.portfolio.video.index'), compact('videos'))
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

        return view(themedTemplate('guest.portfolio.video.show'), compact('video'));
    }
}
