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
     *
     * @param Admin $admin
     * @param Request $request
     * @return View
     */
    public function index(Admin $admin, Request $request): View
    {
        $owner = $admin;

        $perPage = $request->query('per_page', $this->perPage());

        $readings = Reading::where('owner_id', $owner->id)
            ->orderBy('title', 'asc')->orderBy('author', 'asc')
            ->paginate($perPage);

        return view(themedTemplate('guest.personal.reading.index'), compact('owner', 'readings'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Display the specified reading.
     *
     * @param Admin $admin
     * @param string $slug
     * @return View
     */
    public function show(Admin $admin, string $slug): View
    {
        $owner = $admin;

        if (!$reading = Reading::where('owner_id', $owner->id)->where('slug', $slug)->first()) {
            throw new ModelNotFoundException();
        }

        return view(themedTemplate('guest.personal.reading.show'), compact('owner', 'reading'));
    }
}
