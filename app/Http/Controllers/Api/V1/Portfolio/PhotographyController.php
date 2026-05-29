<?php

namespace App\Http\Controllers\Api\V1\Portfolio;

use App\Http\Controllers\Controller;
use App\Models\Portfolio\Photography;
use App\Traits\GuestControllerTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 *
 */
class PhotographyController extends Controller
{
    use GuestControllerTrait;

    /**
     * Display the portfolio photography for the specified admin.
     *
     * @param string $owner_id
     * @return JsonResponse
     * @throws Exception
     */
    public function show(string $owner_id): JsonResponse
    {
        $perPage = request()->query('per_page', $this->perPage());
        $page    = request()->query('page');

        $query = new Photography()->searchQuery(
            request()->except('id'),
            request()->input('sort') ?? implode('|', Photography::SEARCH_ORDER_BY))
        ->where('photography.owner_id', $owner_id);

        if (!empty($page)) {
            $photographies = $query->paginate($perPage)->appends(request()->except('page'));
        } else {
            $photographies = $query->get();
        }

        return response()->json($photographies)->setStatusCode(Response::HTTP_OK);
    }
}
