<?php

namespace App\Http\Controllers\Api\V1\Career;

use App\Http\Controllers\Controller;
use App\Http\Resources\Career\JobBoardCollection;
use App\Http\Resources\Career\JobBoardResource;
use App\Models\Career\JobBoard;
use App\Traits\GuestControllerTrait;
use Exception;
use Illuminate\Http\JsonResponse;

/**
 *
 */
class JobBoardController extends Controller
{
    use GuestControllerTrait;

    /**
     * Display a listing of career job boards.
     * @throws Exception
     */
    public function index(): JsonResponse
    {
        $perPage = request()->query('per_page', $this->perPage());
        $page    = request()->query('page');

        $query = new JobBoard()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', JobBoard::SEARCH_ORDER_BY));

        if (!empty($page)) {
            $jobBoards = $query->paginate($perPage)->appends(request()->except('page'));
        } else {
            $jobBoards = $query->get();
        }

        return new JobBoardCollection($jobBoards)->response();
    }

    /**
     * Display the specified career job board.
     *
     * @param JobBoard $jobBoard
     * @return JsonResponse
     */
    public function show(JobBoard $jobBoard): JsonResponse
    {
        return new JobBoardResource($jobBoard)->response();
    }
}
