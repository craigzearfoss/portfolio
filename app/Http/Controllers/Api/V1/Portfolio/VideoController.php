<?php

namespace App\Http\Controllers\Api\V1\Portfolio;

use App\Http\Controllers\Controller;
use App\Models\Portfolio\Video;
use App\Traits\GuestControllerTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 *
 */
class VideoController extends Controller
{
    use GuestControllerTrait;

    /**
     * Display the portfolio videos for the specified admin.
     *
     * @param string $owner_id
     * @return JsonResponse
     * @throws Exception
     */
    public function show(string $owner_id): JsonResponse
    {
        $perPage = request()->query('per_page', $this->perPage());
        $page    = request()->query('page');

        $query = new Video()->searchQuery(
            request()->except('id'),
            request()->input('sort') ?? implode('|', Video::SEARCH_ORDER_BY))
        ->where('videos.owner_id', $owner_id);

        if (!empty($page)) {
            $videos = $query->paginate($perPage)->appends(request()->except('page'));
        } else {
            $videos = $query->get();
        }

        return response()->json($videos)->setStatusCode(Response::HTTP_OK);
    }
}
