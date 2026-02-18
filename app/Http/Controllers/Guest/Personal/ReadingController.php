<?php

namespace App\Http\Controllers\Guest\Personal;

use App\Http\Controllers\Guest\BaseGuestController;
use App\Models\Personal\Reading;
use App\Models\System\Admin;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 *
 */
class ReadingController extends BaseGuestController
{
    /**
     * Display a listing of readings.
     * NOTE: $this->owner is set in the BaseController->initialize() method.
     *
     * @param Admin $admin
     * @param Request $request
     * @return View
     */
    public function index(Admin $admin, Request $request): View
    {
        $perPage = $request->query('per_page', $this->perPage());

        $readings = new Reading()->searchQuery($request->all(), $this->owner)
            ->orderBy('title')
            ->paginate($perPage)->appends(request()->except('page'));

        return view(themedTemplate('guest.personal.reading.index'), compact('readings'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Display the specified reading.
     * NOTE: $this->owner is set in the BaseController->initialize() method.
     *
     * @param Admin $admin
     * @param string $slug
     * @return View
     */
    public function show(Admin $admin, string $slug): View
    {
        if (!$reading = new Reading()->where('owner_id', $this->owner->id)->where('slug', $slug)->first()) {
            throw new ModelNotFoundException();
        }

        return view(themedTemplate('guest.personal.reading.show'), compact('reading'));
    }
}
