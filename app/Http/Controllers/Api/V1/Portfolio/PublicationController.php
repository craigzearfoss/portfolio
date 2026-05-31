<?php

namespace App\Http\Controllers\Api\V1\Portfolio;

use App\Http\Controllers\Controller;
use App\Http\Resources\Portfolio\PublicationResource;
use App\Models\Portfolio\Publication;
use App\Models\System\Owner;
use App\Traits\GuestControllerTrait;
use Exception;
use Illuminate\Http\JsonResponse;

/**
 *
 */
class PublicationController extends Controller
{
    use GuestControllerTrait;

    /**
     * Display the specified portfolio publication.
     *
     * @param Publication $publication
     * @return JsonResponse
     * @throws Exception
     */
    public function show(Publication $publication): JsonResponse
    {
        return new PublicationResource($publication)->response();
    }
}
