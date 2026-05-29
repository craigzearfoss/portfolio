<?php

namespace App\Http\Controllers\Api\V1\Career;

use App\Http\Controllers\Controller;
use App\Models\Career\Recruiter;
use App\Models\System\Owner;
use App\Traits\GuestControllerTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 *
 */
class RecruiterController extends Controller
{
    use GuestControllerTrait;

    /**
     * Display a listing of career recruiters.
     * @throws Exception
     */
    public function index(): JsonResponse
    {
        $perPage = request()->query('per_page', $this->perPage());
        $page    = request()->query('page');

        $query = new Recruiter()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', Recruiter::SEARCH_ORDER_BY));

        if (!empty($page)) {
            $recruiters = $query->paginate($perPage)->appends(request()->except('page'));
        } else {
            $recruiters = $query->get();
        }

        return response()->json($recruiters)->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Display the specified career recruiter.
     *
     * @param string $id
     * @return JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        if (!new Owner()->newQuery()->find($id)) {
            return response()->json([ 'message' => "Recruiter `{$id}` not found." ])->setStatusCode(Response::HTTP_NO_CONTENT);
        } else {
            $recruiter = Recruiter::query()->where('id', '=', $id)->get();
            return response()->json($recruiter)->setStatusCode(Response::HTTP_OK);
        }
    }
}
