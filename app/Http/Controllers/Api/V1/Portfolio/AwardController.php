<?php

namespace App\Http\Controllers\Api\V1\Portfolio;

use App\Http\Controllers\Controller;
use App\Models\Portfolio\Award;
use App\Traits\GuestControllerTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 *
 */
class AwardController extends Controller
{
    use GuestControllerTrait;

    /**
     * Display the portfolio awards for the specified admin.
     *
     * @param string $owner_id
     * @return JsonResponse
     * @throws Exception
     */
    public function show(string $owner_id): JsonResponse
    {
        $perPage = request()->query('per_page', $this->perPage());
        $page    = request()->query('page');

        $query = new Award()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', Award::SEARCH_ORDER_BY))
        ->where('awards.owner_id', $owner_id);

        if (!empty($page)) {
            $awards = $query->paginate($perPage)->appends(request()->except('page'));
        } else {
            $awards = $query->get();
        }

        return response()->json($awards)->setStatusCode(Response::HTTP_OK);
    }
}
