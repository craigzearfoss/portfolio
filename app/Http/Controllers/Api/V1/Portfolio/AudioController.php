<?php

namespace App\Http\Controllers\Api\V1\Portfolio;

use App\Http\Controllers\Controller;
use App\Http\Resources\Portfolio\AudioCollection;
use App\Http\Resources\Portfolio\AudioResource;
use App\Models\Portfolio\Audio;
use App\Traits\GuestControllerTrait;
use Exception;
use Illuminate\Http\JsonResponse;

/**
 *
 */
class AudioController extends Controller
{
    use GuestControllerTrait;

    /**
     * Display the specified portfolio audio.
     *
     * @param Audio $audio
     * @return JsonResponse
     * @throws Exception
     */
    public function show(Audio $audio): JsonResponse
    {
        return new AudioResource($audio)->response();
    }
}
