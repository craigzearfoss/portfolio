<?php

namespace App\Http\Controllers\Api\V1\Portfolio;

use App\Http\Controllers\Controller;
use App\Http\Resources\Portfolio\LinkResource;
use App\Models\Portfolio\Link;
use App\Traits\GuestControllerTrait;
use Exception;
use Illuminate\Http\JsonResponse;

/**
 *
 */
class LinkController extends Controller
{
    use GuestControllerTrait;

    /**
     * Display the specified portfolio link.
     *
     * @param Link $link
     * @return JsonResponse
     * @throws Exception
     */
    public function show(Link $link): JsonResponse
    {
        return new LinkResource($link)->response();
    }
}
