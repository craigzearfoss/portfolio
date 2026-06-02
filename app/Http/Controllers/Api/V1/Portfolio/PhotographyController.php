<?php

namespace App\Http\Controllers\Api\V1\Portfolio;

use App\Http\Controllers\Controller;
use App\Http\Resources\Portfolio\PhotographyResource;
use App\Models\Portfolio\Photography;
use App\Traits\GuestControllerTrait;
use Exception;
use Illuminate\Http\JsonResponse;

/**
 *
 */
class PhotographyController extends Controller
{
    use GuestControllerTrait;

    /**
     * Display the specified portfolio photography.
     *
     * @param Photography $photography
     * @return JsonResponse
     * @throws Exception
     */
    public function show(Photography $photography): JsonResponse
    {
        return new PhotographyResource($photography)->response();
    }
}
