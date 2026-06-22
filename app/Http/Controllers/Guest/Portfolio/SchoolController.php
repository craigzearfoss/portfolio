<?php

namespace App\Http\Controllers\Guest\Portfolio;

use App\Enums\EnvTypes;
use App\Http\Controllers\Guest\BaseGuestController;
use App\Models\Portfolio\School;
use App\Models\System\Admin;
use App\Services\PermissionService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 *
 */
class SchoolController extends BaseGuestController
{
    public function __construct(PermissionService $permissionService)
    {
        parent::__construct($permissionService, EnvTypes::GUEST);

        view()->share('resourceType', 'portfolio.school');
    }

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

        $schools = new School()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', School::SEARCH_ORDER_BY),
            $this->owner ?? null
        )->where('schools.name', '!=', 'other')
        ->paginate($perPage)->appends(request()->except('page'));

        $pageTitle = 'Schools';

        return view(themedTemplate('guest.portfolio.school.index'), compact('schools', 'pageTitle'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Display the specified reading.
     *
     * @param string $slug
     * @return View
     */
    public function show(string $slug): View
    {
        if (!$school = School::query()->where('slug', '=', $slug)->first()) {
            throw new ModelNotFoundException();
        }

        return view(themedTemplate('guest.portfolio.school.show'), compact('school'));
    }
}
