<?php

namespace App\Http\Controllers\Api\V1\Portfolio;

use App\Http\Controllers\Controller;
use App\Models\Portfolio\Publication;
use App\Traits\GuestControllerTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 *
 */
class PublicationController extends Controller
{
    use GuestControllerTrait;

    /**
     * Display the portfolio publications for the specified admin.
     *
     * @param string $owner_id
     * @return JsonResponse
     * @throws Exception
     */
    public function show(string $owner_id): JsonResponse
    {
        $perPage = request()->query('per_page', $this->perPage());
        $page    = request()->query('page');

        $query = new Publication()->searchQuery(
            request()->except('id'),
            request()->input('sort') ?? implode('|', Publication::SEARCH_ORDER_BY))
        ->where('publications.owner_id', $owner_id);

        if (!empty($page)) {
            $publications = $query->paginate($perPage)->appends(request()->except('page'));
        } else {
            $publications = $query->get();
        }

        return response()->json($publications)->setStatusCode(Response::HTTP_OK);
    }
}
