<?php

namespace App\Http\Controllers\Api\V1\Portfolio;

use App\Http\Controllers\Controller;
use App\Http\Resources\Portfolio\VideoResource;
use App\Models\Portfolio\Video;
use App\Traits\GuestControllerTrait;
use Exception;
use Illuminate\Http\JsonResponse;

/**
 *
 */
class VideoController extends Controller
{
    use GuestControllerTrait;

    /**
     * Display the specified portfolio video.
     *
     * @param Video $video
     * @return JsonResponse
     * @throws Exception
     */
    public function show(Video $video): JsonResponse
    {
        return new VideoResource($video)->response();
    }
}
