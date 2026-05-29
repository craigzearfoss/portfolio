<?php

namespace App\Http\Controllers\Api\V1\Portfolio;

use App\Http\Controllers\Controller;
use App\Models\Portfolio\Link;
use App\Traits\GuestControllerTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 *
 */
class LinkController extends Controller
{
    use GuestControllerTrait;

    /**
     * Display the portfolio links for the specified admin.
     *
     * @param string $owner_id
     * @return JsonResponse
     * @throws Exception
     */
    public function show(string $owner_id): JsonResponse
    {
        $perPage = request()->query('per_page', $this->perPage());
        $page    = request()->query('page');

        $query = new Link()->searchQuery(
            request()->except('id'),
            request()->input('sort') ?? implode('|', Link::SEARCH_ORDER_BY))
        ->where('links.owner_id', $owner_id);

        if (!empty($page)) {
            $links = $query->paginate($perPage)->appends(request()->except('page'));
        } else {
            $links = $query->get();
        }

        return response()->json($links)->setStatusCode(Response::HTTP_OK);
    }
}
