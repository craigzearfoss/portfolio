<?php

namespace App\Http\Controllers\Api\V1\Portfolio;

use App\Http\Controllers\Controller;
use App\Http\Resources\Portfolio\ProjectResource;
use App\Models\Portfolio\Project;
use App\Traits\GuestControllerTrait;
use Exception;
use Illuminate\Http\JsonResponse;

/**
 *
 */
class ProjectController extends Controller
{
    use GuestControllerTrait;

    /**
     * Display the specified portfolio project.
     *
     * @param Project $project
     * @return JsonResponse
     * @throws Exception
     */
    public function show(Project $project): JsonResponse
    {
        return new ProjectResource($project)->response();
    }
}
