<?php

namespace App\Http\Controllers\Api\V1\Portfolio;

use App\Http\Controllers\Controller;
use App\Models\Portfolio\Project;
use App\Traits\GuestControllerTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 *
 */
class ProjectController extends Controller
{
    use GuestControllerTrait;

    /**
     * Display the portfolio projects for the specified admin.
     *
     * @param string $owner_id
     * @return JsonResponse
     * @throws Exception
     */
    public function show(string $owner_id): JsonResponse
    {
        $perPage = request()->query('per_page', $this->perPage());
        $page    = request()->query('page');

        $query = new Project()->searchQuery(
            request()->except('id'),
            request()->input('sort') ?? implode('|', Project::SEARCH_ORDER_BY))
        ->where('projects.owner_id', $owner_id);

        if (!empty($page)) {
            $projects = $query->paginate($perPage)->appends(request()->except('page'));
        } else {
            $projects = $query->get();
        }

        return response()->json($projects)->setStatusCode(Response::HTTP_OK);
    }
}
