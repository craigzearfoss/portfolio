<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CandidateResource;
use App\Models\System\Owner;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CandidateController extends Controller
{
    /**
     * Display the specified candidate.
     *
     * @param Owner $owner
     * @return JsonResponse
     * @throws Exception
     */
    public function show(Owner $owner): JsonResponse
    {
        return new CandidateResource($owner)->response();
    }
}
