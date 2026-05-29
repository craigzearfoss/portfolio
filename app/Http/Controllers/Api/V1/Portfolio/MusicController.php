<?php

namespace App\Http\Controllers\Api\V1\Portfolio;

use App\Http\Controllers\Controller;
use App\Models\Portfolio\Music;
use App\Traits\GuestControllerTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 *
 */
class MusicController extends Controller
{
    use GuestControllerTrait;

    /**
     * Display the portfolio music for the specified admin.
     *
     * @param string $owner_id
     * @return JsonResponse
     * @throws Exception
     */
    public function show(string $owner_id): JsonResponse
    {
        $perPage = request()->query('per_page', $this->perPage());
        $page    = request()->query('page');

        $query = new Music()->searchQuery(
            request()->except('id'),
            request()->input('sort') ?? implode('|', Music::SEARCH_ORDER_BY))
        ->where('music.owner_id', $owner_id);

        if (!empty($page)) {
            $musics = $query->paginate($perPage)->appends(request()->except('page'));
        } else {
            $musics = $query->get();
        }

        return response()->json($musics)->setStatusCode(Response::HTTP_OK);
    }
}
