<?php

namespace App\Http\Controllers\Guest\Portfolio;

use App\Http\Controllers\Guest\BaseGuestController;
use App\Models\Portfolio\Academy;
use App\Models\System\Admin;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 *
 */
class AcademyController extends BaseGuestController
{
    /**
     * Display a listing of readings.
     *
     * @param Request $request
     * @return View
     * @throws Exception
     */
    public function index(Request $request): View
    {
        $perPage = $request->query('per_page', $this->perPage());

        $academies = new Academy()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', Academy::SEARCH_ORDER_BY),
            $this->owner ?? null
        )->where('academies.name', '!=', 'other')
        ->paginate($perPage)->appends(request()->except('page'));

        $pageTitle = 'Online Learning';

        return view(themedTemplate('guest.portfolio.academy.index'), compact('academies', 'pageTitle'))
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
        if (!$academy = Academy::query()->where('owner_id', '=', $admin['id'])
            ->where('slug', '=', $slug)->first()
        ) {
            throw new ModelNotFoundException();
        }

        return view(themedTemplate('guest.portfolio.academy.show'), compact('academy'));
    }
}
