<?php

namespace App\Http\Controllers\Api\V1\Portfolio;

use App\Http\Controllers\Controller;
use App\Http\Resources\Portfolio\JobResource;
use App\Models\Portfolio\Job;
use App\Traits\GuestControllerTrait;
use Exception;
use Illuminate\Http\JsonResponse;

/**
 *
 */
class JobController extends Controller
{
    use GuestControllerTrait;

    /**
     * Display the specified portfolio job.
     *
     * @param Job $job
     * @return JsonResponse
     * @throws Exception
     */
    public function show(Job $job): JsonResponse
    {
        return new JobResource($job)->response();
    }
}
