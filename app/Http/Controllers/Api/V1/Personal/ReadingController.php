<?php

namespace App\Http\Controllers\Api\V1\Personal;

use App\Http\Controllers\Controller;
use App\Models\Personal\Reading;
use App\Traits\GuestControllerTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 *
 */
class ReadingController extends Controller
{
    use GuestControllerTrait;

    /**
     * Display the personal readings for the specified admin.
     *
     * @param string $owner_id
     * @return JsonResponse
     * @throws Exception
     */
    public function show(string $owner_id): JsonResponse
    {
        $perPage = request()->query('per_page', $this->perPage());
        $page    = request()->query('page');

        $query = new Reading()->searchQuery(
            request()->except('id'),
            request()->input('sort') ?? implode('|', Reading::SEARCH_ORDER_BY))
        ->where('readings.owner_id', $owner_id);

        if (!empty($page)) {
            $readings = $query->paginate($perPage)->appends(request()->except('page'));
        } else {
            $readings = $query->get();
        }

        return response()->json($readings)->setStatusCode(Response::HTTP_OK);
    }
}
