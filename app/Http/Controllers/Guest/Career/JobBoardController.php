<?php

namespace App\Http\Controllers\Guest\Career;

use App\Enums\EnvTypes;
use App\Http\Controllers\Guest\BaseGuestController;
use App\Models\Career\JobBoard;
use App\Models\System\Admin;
use App\Services\PermissionService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 *
 */
class JobBoardController extends BaseGuestController
{
    public function __construct(PermissionService $permissionService)
    {
        parent::__construct($permissionService, EnvTypes::GUEST);

        view()->share('resourceType', 'career.job_board');
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

        $jobBoards = new JobBoard()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', JobBoard::SEARCH_ORDER_BY),
            null
        )
        ->where('job_boards.name', '!=', 'other')
        ->where('job_boards.name', '!=', 'COMPANY WEBSITE')
        ->where('job_boards.name', '!=',  'INQUIRY')
        ->paginate($perPage)->appends(request()->except('page'));

        $pageTitle = 'Job Boards';

        return view(themedTemplate('guest.career.job-board.index'), compact('jobBoards', 'pageTitle'))
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
        if (!$jobBoard = JobBoard::query()->where('slug', '=', $slug)->first()
        ) {
            throw new ModelNotFoundException();
        }

        return view(themedTemplate('guest.career.job-board.show'), compact('jobBoard'));
    }
}
