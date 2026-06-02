<?php

namespace App\Http\Controllers\Api\V1\Personal;

use App\Http\Controllers\Controller;
use App\Http\Resources\Personal\ReadingCollection;
use App\Http\Resources\Personal\ReadingResource;
use App\Models\Personal\Reading;
use App\Traits\GuestControllerTrait;
use Exception;
use Illuminate\Http\JsonResponse;

/**
 *
 */
class ReadingController extends Controller
{
    use GuestControllerTrait;

    /**
     * Display a listing of personal readings. The parameter candidate_id is required.
     * @throws Exception
     */
    public function index(): JsonResponse
    {
        if (!$candidateId = request()->input('candidate_id')) {
            return response()->json([ 'success' => false, 'message' => 'candidate_id required.' ], 400);
        }
        $params = request()->except('candidate_id');
        $params['owner_id'] = $candidateId;

        $perPage = request()->query('per_page', $this->perPage());
        $page    = request()->query('page');

        $query = new Reading()->searchQuery(
            $params,
            request()->input('sort') ?? implode('|', Reading::SEARCH_ORDER_BY));

        if (!empty($page)) {
            $readings = $query->paginate($perPage)->appends(request()->except('page'));
        } else {
            $readings = $query->get();
        }

        return new ReadingCollection($readings)->response();
    }

    /**
     * Display the specified personal reading.
     *
     * @param Reading $reading
     * @return JsonResponse
     * @throws Exception
     */
    public function show(Reading $reading): JsonResponse
    {
        return new ReadingResource($reading)->response();
    }
}
