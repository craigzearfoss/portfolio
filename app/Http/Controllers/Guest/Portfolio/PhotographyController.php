<?php

namespace App\Http\Controllers\Guest\Portfolio;

use App\Http\Controllers\Guest\BaseGuestController;
use App\Models\Portfolio\Photography;
use App\Models\System\Admin;
use Exception;
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
     * @throws Exception
     */
    public function index(Request $request): View
    {
        $perPage = $request->query('per_page', $this->perPage());

        $photos = new Photography()->searchQuery(
        request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', Photography::SEARCH_ORDER_BY),
        $this->owner ?? null
        )
        ->paginate($perPage)->appends(request()->except('page'));

        $pageTitle = ($this->owner->name  ?? '') . ' Photography';

        return view(themedTemplate('guest.portfolio.photography.index', 'pageTitle'), compact('photos'))
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
        if (!$photo = Photography::query()->where('owner_id', '=', $admin['id'])
            ->where('slug', '=', $slug)->first()
        ) {
            throw new ModelNotFoundException();
        }

        return view(themedTemplate('guest.portfolio.photography.show'), compact('photo'));
    }
}
