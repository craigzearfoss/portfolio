<?php

namespace App\Http\Controllers\Api\V1\Portfolio;

use App\Http\Controllers\Controller;
use App\Http\Resources\Portfolio\MusicResource;
use App\Models\Portfolio\Music;
use App\Traits\GuestControllerTrait;
use Exception;
use Illuminate\Http\JsonResponse;

/**
 *
 */
class MusicController extends Controller
{
    use GuestControllerTrait;

    /**
     * Display the specified portfolio music.
     *
     * @param Music $music
     * @return JsonResponse
     * @throws Exception
     */
    public function show(Music $music): JsonResponse
    {
        return new MusicResource($music)->response();
    }
}
