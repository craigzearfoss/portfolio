<?php

namespace App\Http\Controllers\Guest\Portfolio;

use App\Http\Controllers\Guest\BaseGuestController;
use App\Models\Portfolio\Education;
use App\Models\System\Admin;
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
     */
    public function index(Request $request): View
    {
        $perPage = $request->query('per_page', $this->perPage());

        $educations = new Education()->searchQuery(
            request()->except('id'),
                $this->owner ?? null
        )
        ->orderBy('graduation_year')
        ->paginate($perPage)->appends(request()->except('page'));

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
