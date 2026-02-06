<?php

namespace App\Http\Controllers\Guest\Portfolio;

use App\Http\Controllers\Guest\BaseGuestController;
use App\Models\Portfolio\Publication;
use App\Models\System\Admin;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 *
 */
class PublicationController extends BaseGuestController
{
    /**
     * Display a listing of publications.
     * NOTE: $this->owner is set in the BaseController->initialize() method.
     *
     * @param Admin $admin
     * @param Request $request
     * @return View
     */
    public function index(Admin $admin, Request $request): View
    {
        $perPage = $request->query('per_page', $this->perPage());

        $publications = Publication::where('owner_id', $this->owner->id)
            ->orderBy('title', 'asc')
            ->paginate($perPage);

        return view(themedTemplate('guest.portfolio.publication.index'), compact('publications'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Display the specified publication.
     * NOTE: $this->owner is set in the BaseController->initialize() method.
     *
     * @param Admin $admin
     * @param string $slug
     * @return View
     */
    public function show(Admin $admin, string $slug): View
    {
        if (!$publication = Publication::where('owner_id', $this->owner->id)->where('slug', $slug)->first()) {
            throw new ModelNotFoundException();
        }

        return view(themedTemplate('guest.portfolio.publication.show'), compact('publication'));
    }
}
