<?php

namespace App\Http\Controllers\Api\V1\Portfolio;

use App\Http\Controllers\Controller;
use App\Http\Resources\Portfolio\AwardCollection;
use App\Http\Resources\Portfolio\AwardResource;
use App\Models\Portfolio\Award;
use App\Traits\GuestControllerTrait;
use Exception;
use Illuminate\Http\JsonResponse;

/**
 *
 */
class AwardController extends Controller
{
    use GuestControllerTrait;

    /**
     * Display the specified portfolio award.
     *
     * @param Award $award
     * @return JsonResponse
     * @throws Exception
     */
    public function show(Award $award): JsonResponse
    {
        return new AwardResource($award)->response();
    }
}
