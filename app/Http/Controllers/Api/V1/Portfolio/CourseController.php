<?php

namespace App\Http\Controllers\Api\V1\Portfolio;

use App\Http\Controllers\Controller;
use App\Http\Resources\Portfolio\CourseResource;
use App\Models\Portfolio\Course;
use App\Traits\GuestControllerTrait;
use Exception;
use Illuminate\Http\JsonResponse;

/**
 *
 */
class CourseController extends Controller
{
    use GuestControllerTrait;

    /**
     * Display the specified portfolio course.
     *
     * @param Course $course
     * @return JsonResponse
     * @throws Exception
     */
    public function show(Course $course): JsonResponse
    {
        return new CourseResource($course)->response();
    }
}
