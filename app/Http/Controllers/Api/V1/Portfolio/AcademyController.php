<?php

namespace App\Http\Controllers\Api\V1\Portfolio;

use App\Http\Controllers\Controller;
use App\Models\Portfolio\Academy;
use App\Models\System\Owner;
use App\Traits\GuestControllerTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 *
 */
class AcademyController extends Controller
{
    use GuestControllerTrait;

    /**
     * Display a listing of portfolio academies.
     * @throws Exception
     */
    public function index(): JsonResponse
    {
        $perPage = request()->query('per_page', $this->perPage());
        $page    = request()->query('page');

        $query = new Academy()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', Academy::SEARCH_ORDER_BY));

        if (!empty($page)) {
            $academies = $query->paginate($perPage)->appends(request()->except('page'));
        } else {
            $academies = $query->get();
        }

        return response()->json($academies)->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Display the specified portfolio academy.
     *
     * @param string $id
     * @return JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        if (!new Owner()->newQuery()->find($id)) {
            return response()->json([ 'message' => "Academy `{$id}` not found." ])->setStatusCode(Response::HTTP_NO_CONTENT);
        } else {
            $academy = Academy::query()->where('id', '=', $id)->get();
            return response()->json($academy)->setStatusCode(Response::HTTP_OK);
        }
    }
}
