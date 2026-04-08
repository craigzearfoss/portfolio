<?php

namespace App\Http\Controllers\Guest\Portfolio;

use App\Http\Controllers\Guest\BaseGuestController;
use App\Models\Portfolio\Video;
use App\Models\System\Admin;
use Exception;
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
     * @throws Exception
     */
    public function index(Request $request): View
    {
        $perPage = $request->query('per_page', $this->perPage());

        $videos = new Video()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', Video::SEARCH_ORDER_BY),
            $this->owner ?? null
        )
        ->paginate($perPage)->appends(request()->except('page'));

        $pageTitle = ($this->owner->name  ?? '') . ' Videos';

        return view(themedTemplate('guest.portfolio.video.index', 'pageTitle'), compact('videos'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Display the specified video.
     *
     * @param Admin $admin
     * @param string $slug
     * @return View
     */
    public function show(Admin $admin, string $slug): View
    {
        if (!$video = Video::query()->where('owner_id', '=', $admin['id'])
            ->where('slug', '=', $slug)->first()
        ) {
            throw new ModelNotFoundException();
        }

        return view(themedTemplate('guest.portfolio.video.show'), compact('video'));
    }
}
