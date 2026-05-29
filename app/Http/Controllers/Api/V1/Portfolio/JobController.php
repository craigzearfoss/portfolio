<?php

namespace App\Http\Controllers\Api\V1\Portfolio;

use App\Http\Controllers\Controller;
use App\Models\Portfolio\Job;
use App\Traits\GuestControllerTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 *
 */
class JobController extends Controller
{
    use GuestControllerTrait;

    /**
     * Display the portfolio jobs for the specified admin.
     *
     * @param string $owner_id
     * @return JsonResponse
     * @throws Exception
     */
    public function show(string $owner_id): JsonResponse
    {
        $perPage = request()->query('per_page', $this->perPage());
        $page    = request()->query('page');

        $query = new Job()->searchQuery(
            request()->except('id'),
            request()->input('sort') ?? implode('|', Job::SEARCH_ORDER_BY))
        ->where('jobs.owner_id', $owner_id);

        if (!empty($page)) {
            $jobs = $query->paginate($perPage)->appends(request()->except('page'));
        } else {
            $jobs = $query->get();
        }

        return response()->json($jobs)->setStatusCode(Response::HTTP_OK);
    }
}
