<?php

namespace App\Http\Controllers\Guest\Portfolio;

use App\Http\Controllers\Guest\BaseGuestController;
use App\Models\Portfolio\Music;
use App\Models\System\Admin;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 *
 */
class MusicController extends BaseGuestController
{
    /**
     * Display a listing of music.
     *
     * @param Request $request
     * @return View
     * @throws Exception
     */
    public function index(Request $request): View
    {
        $perPage = $request->query('per_page', $this->perPage());

        $musics = new Music()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', Music::SEARCH_ORDER_BY),
            $this->owner ?? null
        )
        ->paginate($perPage)->appends(request()->except('page'));

        $pageTitle = ($this->owner->name  ?? '') . ' Music';

        return view(themedTemplate('guest.portfolio.music.index', 'pageTitle'), compact('musics'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Display the specified music.
     *
     * @param Admin $admin
     * @param string $slug
     * @return View
     */
    public function show(Admin $admin, string $slug): View
    {
        if (!$music = Music::query()->where('owner_id', '=', $admin['id'])
            ->where('slug', '=', $slug)->first()
        ) {
            throw new ModelNotFoundException();
        }

        return view(themedTemplate('guest.portfolio.music.show'), compact('music'));
    }
}
