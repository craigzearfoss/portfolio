<?php

namespace App\Http\Controllers\Api\V1\Career;

use App\Http\Controllers\Controller;
use App\Models\Career\JobBoard;
use App\Models\System\Owner;
use App\Traits\GuestControllerTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

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

        return response()->json($jobBoards)->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Display the specified career job board.
     *
     * @param string $id
     * @return JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        if (!new Owner()->newQuery()->find($id)) {
            return response()->json([ 'message' => "Job board `{$id}` not found." ])->setStatusCode(Response::HTTP_NO_CONTENT);
        } else {
            $jobBoard = JobBoard::query()->where('id', '=', $id)->get();
            return response()->json($jobBoard)->setStatusCode(Response::HTTP_OK);
        }
    }
}
