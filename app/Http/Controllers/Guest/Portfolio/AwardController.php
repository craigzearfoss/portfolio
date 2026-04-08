<?php

namespace App\Http\Controllers\Guest\Portfolio;

use App\Http\Controllers\Guest\BaseGuestController;
use App\Models\Portfolio\Award;
use App\Models\System\Admin;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 *
 */
class AwardController extends BaseGuestController
{
    /**
     * Display a listing of awards.
     *
     * @param Request $request
     * @return View
     * @throws Exception
     */
    public function index(Request $request): View
    {
        $perPage = $request->query('per_page', $this->perPage());

        $awards = new Award()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', Award::SEARCH_ORDER_BY),
            $this->owner ?? null
        )
        ->paginate($perPage)->appends(request()->except('page'));

        $pageTitle = ($this->owner->name  ?? '') . ' Awards';

        return view(themedTemplate('guest.portfolio.award.index'), compact('awards', 'pageTitle'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Display the specified award.
     *
     * @param Admin $admin
     * @param string $slug
     * @return View
     */
    public function show(Admin $admin, string $slug): View
    {
        if (!$award = Award::query()->where('owner_id', '=', $admin['id'])
            ->where('slug', '=', $slug)->first()
        ) {
            throw new ModelNotFoundException();
        }

        return view(themedTemplate('guest.portfolio.award.show'), compact('award'));
    }
}
