<?php

namespace App\Http\Controllers\Guest\Portfolio;

use App\Http\Controllers\Guest\BaseGuestController;
use App\Models\Portfolio\Music;
use App\Models\System\Admin;
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
     * NOTE: $this->owner is set in the BaseController->initialize() method.
     *
     * @param Admin $admin
     * @param Request $request
     * @return View
     */
    public function index(Admin $admin, Request $request): View
    {
        $perPage = $request->query('per_page', $this->perPage());

        $musics = Music::where('owner_id', $this->owner->id)
            ->orderBy('name', 'asc')->orderBy('artist', 'asc')
            ->paginate($perPage);

        return view(themedTemplate('guest.portfolio.music.index'), compact('musics'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Display the specified music.
     * NOTE: $this->owner is set in the BaseController->initialize() method.
     *
     * @param Admin $admin
     * @param string $slug
     * @return View
     */
    public function show(Admin $admin, string $slug): View
    {
        if (!$music = Music::where('owner_id', $this->owner->id)->where('slug', $slug)->first()) {
            throw new ModelNotFoundException();
        }

        return view(themedTemplate('guest.portfolio.music.show'), compact('music'));
    }
}
