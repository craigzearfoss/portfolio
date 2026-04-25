<?php

namespace App\Http\Controllers\Guest\Portfolio;

use App\Http\Controllers\Guest\BaseGuestController;
use App\Models\Portfolio\Education;
use App\Models\System\Admin;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 *
 */
class EducationController extends BaseGuestController
{
    /**
     * Display a listing of educations.
     *
     * @param Request $request
     * @return View
     * @throws Exception
     */
    public function index(Request $request): View
    {
        $perPage = $request->query('per_page', $this->perPage());

        $educations = new Education()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', Education::SEARCH_ORDER_BY),
            $this->owner ?? null
        )
        ->paginate($perPage)->appends(request()->except('page'));

        $pageTitle = ($this->owner->name  ?? '') . ' Education';

        return view(themedTemplate('guest.portfolio.education.index'), compact('educations'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Display the specified education.
     *
     * @param Admin $admin
     * @param int $id
     * @return View
     */
    public function show(Admin $admin, int $id): View
    {
        if (!$education = Education::query()->where('owner_id', '=', $admin['id'])
            ->where('id', '=', $id)->first()
        ) {
            throw new ModelNotFoundException();
        }

        return view(themedTemplate('guest.portfolio.education.show'), compact('education'));
    }
}
