<?php

namespace App\Http\Controllers\Guest\Career;

use App\Http\Controllers\Guest\BaseGuestController;
use App\Models\Career\Recruiter;
use App\Models\System\Admin;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 *
 */
class RecruiterController extends BaseGuestController
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

        $recruiters = new Recruiter()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', Recruiter::SEARCH_ORDER_BY),
            $this->owner ?? null
        )->where('recruiters.name', '!=', 'other')
        ->paginate($perPage)->appends(request()->except('page'));

        $pageTitle = 'Recruiters & Staffing Firms';

        return view(themedTemplate('guest.career.recruiter.index'), compact('recruiters', 'pageTitle'))
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
        if (!$recruiter = Recruiter::query()->where('owner_id', '=', $admin['id'])
            ->where('slug', '=', $slug)->first()
        ) {
            throw new ModelNotFoundException();
        }

        return view(themedTemplate('guest.career.recruiter.show'), compact('recruiter'));
    }
}
