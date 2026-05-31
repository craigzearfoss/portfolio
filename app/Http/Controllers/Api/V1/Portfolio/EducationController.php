<?php

namespace App\Http\Controllers\Api\V1\Portfolio;

use App\Http\Controllers\Controller;
use App\Http\Resources\Portfolio\EducationResource;
use App\Models\Portfolio\Education;
use App\Traits\GuestControllerTrait;
use Exception;
use Illuminate\Http\JsonResponse;

/**
 *
 */
class EducationController extends Controller
{
    use GuestControllerTrait;

    /**
     * Display the specified portfolio education.
     *
     * @param Education $education
     * @return JsonResponse
     * @throws Exception
     */
    public function show(Education $education): JsonResponse
    {
        return new EducationResource($education)->response();
    }
}
