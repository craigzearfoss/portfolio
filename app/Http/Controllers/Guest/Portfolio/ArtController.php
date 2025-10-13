<?php

namespace App\Http\Controllers\Guest\Portfolio;

use App\Http\Controllers\Guest\BaseGuestController;
use App\Models\Portfolio\Art;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 *
 */
class ArtController extends BaseGuestController
{
    /**
     * Display a listing of art.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $perPage = $request->query('per_page', $this->perPage);

        $arts = Art::where('public', 1)
            ->where('disabled', 0)
            ->orderBy('name', 'asc')->orderBy('artist', 'asc')
            ->paginate($perPage);

        return view(themedTemplate('guest.portfolio.art.index'), compact('arts'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Display the specified art.
     *
     * @param string $slug
     * @return View
     */
    public function show(string $slug): View
    {
        if (!$art = Art::where('slug', $slug)->first()) {
            throw new ModelNotFoundException();
        }

        return view(themedTemplate('guest.portfolio.art.show'), compact('art'));
    }
}
