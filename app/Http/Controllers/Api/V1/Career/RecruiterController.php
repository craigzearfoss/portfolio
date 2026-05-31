<?php

namespace App\Http\Controllers\Api\V1\Career;

use App\Http\Controllers\Controller;
use App\Http\Resources\Career\RecruiterCollection;
use App\Http\Resources\Career\RecruiterResource;
use App\Models\Career\Recruiter;
use App\Traits\GuestControllerTrait;
use Exception;
use Illuminate\Http\JsonResponse;

/**
 *
 */
class RecruiterController extends Controller
{
    use GuestControllerTrait;

    /**
     * Display a listing of career recruiters.
     * @throws Exception
     */
    public function index(): JsonResponse
    {
        $perPage = request()->query('per_page', $this->perPage());
        $page    = request()->query('page');

        $query = new Recruiter()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', Recruiter::SEARCH_ORDER_BY));

        if (!empty($page)) {
            $recruiters = $query->paginate($perPage)->appends(request()->except('page'));
        } else {
            $recruiters = $query->get();
        }

        return new RecruiterCollection($recruiters)->response();
    }

    /**
     * Display the specified career recruiter.
     *
     * @param Recruiter $recruiter
     * @return JsonResponse
     */
    public function show(Recruiter $recruiter): JsonResponse
    {
        return new RecruiterResource($recruiter)->response();
    }
}
