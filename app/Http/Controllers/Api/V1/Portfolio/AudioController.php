<?php

namespace App\Http\Controllers\Api\V1\Portfolio;

use App\Http\Controllers\Controller;
use App\Models\Portfolio\Audio;
use App\Traits\GuestControllerTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 *
 */
class AudioController extends Controller
{
    use GuestControllerTrait;

    /**
     * Display the portfolio audio for the specified admin.
     *
     * @param string $owner_id
     * @return JsonResponse
     * @throws Exception
     */
    public function show(string $owner_id): JsonResponse
    {
        $perPage = request()->query('per_page', $this->perPage());
        $page    = request()->query('page');

        $query = new Audio()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', Audio::SEARCH_ORDER_BY))
        ->where('audios.owner_id', $owner_id);

        if (!empty($page)) {
            $audios = $query->paginate($perPage)->appends(request()->except('page'));
        } else {
            $audios = $query->get();
        }

        return response()->json($audios)->setStatusCode(Response::HTTP_OK);
    }
}
