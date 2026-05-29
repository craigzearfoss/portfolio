<?php

namespace App\Http\Controllers\Api\V1\Portfolio;

use App\Http\Controllers\Controller;
use App\Models\Portfolio\Art;
use App\Traits\GuestControllerTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 *
 */
class ArtController extends Controller
{
    use GuestControllerTrait;

    /**
     * Display the portfolio art for the specified admin.
     *
     * @param string $owner_id
     * @return JsonResponse
     * @throws Exception
     */
    public function show(string $owner_id): JsonResponse
    {
        $perPage = request()->query('per_page', $this->perPage());
        $page    = request()->query('page');

        $query = new Art()->searchQuery(
            request()->except('id'),
            request()->input('sort') ?? implode('|', Art::SEARCH_ORDER_BY))
        ->where('art.owner_id', $owner_id);

        if (!empty($page)) {
            $arts = $query->paginate($perPage)->appends(request()->except('page'));
        } else {
            $arts = $query->get();
        }

        return response()->json($arts)->setStatusCode(Response::HTTP_OK);
    }
}
