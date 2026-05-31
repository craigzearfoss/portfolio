<?php

namespace App\Http\Controllers\Api\V1\Portfolio;

use App\Http\Controllers\Controller;
use App\Http\Resources\Portfolio\ArtCollection;
use App\Http\Resources\Portfolio\ArtResource;
use App\Models\Portfolio\Art;
use App\Traits\GuestControllerTrait;
use Exception;
use Illuminate\Http\JsonResponse;

/**
 *
 */
class ArtController extends Controller
{
    use GuestControllerTrait;

    /**
     * Display the specified portfolio art.
     *
     * @param Art $art
     * @return JsonResponse
     * @throws Exception
     */
    public function show(Art $art): JsonResponse
    {
        return new ArtResource($art)->response();
    }
}
