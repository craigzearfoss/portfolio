<?php

namespace App\Http\Controllers\Api\V1\Portfolio;

use App\Http\Controllers\Controller;
use App\Models\Portfolio\Course;
use App\Traits\GuestControllerTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 *
 */
class CourseController extends Controller
{
    use GuestControllerTrait;

    /**
     * Display the portfolio courses for the specified admin.
     *
     * @param string $owner_id
     * @return JsonResponse
     * @throws Exception
     */
    public function show(string $owner_id): JsonResponse
    {
        $perPage = request()->query('per_page', $this->perPage());
        $page    = request()->query('page');

        $query = new Course()->searchQuery(
            request()->except('id'),
            request()->input('sort') ?? implode('|', Course::SEARCH_ORDER_BY))
        ->where('courses.owner_id', $owner_id);

        if (!empty($page)) {
            $courses = $query->paginate($perPage)->appends(request()->except('page'));
        } else {
            $courses = $query->get();
        }

        return response()->json($courses)->setStatusCode(Response::HTTP_OK);
    }
}
