<?php

namespace App\Http\Controllers\Api\V1\Career;

use App\Http\Controllers\Controller;
use App\Models\Career\Industry;
use App\Models\System\Owner;
use App\Traits\GuestControllerTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 *
 */
class IndustryController extends Controller
{
    use GuestControllerTrait;

    /**
     * Display a listing of career industries.
     * @throws Exception
     */
    public function index(): JsonResponse
    {
        $perPage = request()->query('per_page', $this->perPage());
        $page    = request()->query('page');

        $query = new Industry()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', Industry::SEARCH_ORDER_BY));

        if (!empty($page)) {
            $industries = $query->paginate($perPage)->appends(request()->except('page'));
        } else {
            $industrys = $query->get();
        }

        return response()->json($industrys)->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Display the specified career industry.
     *
     * @param string $id
     * @return JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        if (!new Owner()->newQuery()->find($id)) {
            return response()->json([ 'message' => "Industry `{$id}` not found." ])->setStatusCode(Response::HTTP_NO_CONTENT);
        } else {
            $industry = Industry::query()->where('id', '=', $id)->get();
            return response()->json($industry)->setStatusCode(Response::HTTP_OK);
        }
    }
}
