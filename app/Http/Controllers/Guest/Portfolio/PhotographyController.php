<?php

namespace App\Http\Controllers\Guest\Portfolio;

use App\Http\Controllers\Guest\BaseGuestController;
use App\Models\Portfolio\Photography;
use App\Models\System\Admin;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 *
 */
class PhotographyController extends BaseGuestController
{
    /**
     * Display a listing of photos.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $perPage = $request->query('per_page', $this->perPage());

        $photos = new Photography()->searchQuery(request()->except('id'), $this->owner ?? null)
            ->orderBy('name')
            ->paginate($perPage)->appends(request()->except('page'));

        return view(themedTemplate('guest.portfolio.photography.index'), compact('photos'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Display the specified photo.
     *
     * @param Admin $admin
     * @param string $slug
     * @return View
     */
    public function show(Admin $admin, string $slug): View
    {
        if (!$photo = new Photography()->where('owner_id', '=', $admin['id'])
            ->where('slug', '=', $slug)->first()
        ) {
            throw new ModelNotFoundException();
        }

        return view(themedTemplate('guest.portfolio.photography.show'), compact('photo'));
    }
}
