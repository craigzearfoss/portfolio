<?php

namespace App\Http\Controllers\Api\V1\Portfolio;

use App\Http\Controllers\Controller;
use App\Http\Resources\Portfolio\SchoolCollection;
use App\Http\Resources\Portfolio\SchoolResource;
use App\Models\Portfolio\School;
use App\Traits\GuestControllerTrait;
use Exception;
use Illuminate\Http\JsonResponse;

/**
 *
 */
class SchoolController extends Controller
{
    use GuestControllerTrait;

    /**
     * Display a listing of portfolio schools.
     * @throws Exception
     */
//    public function index(): JsonResponse
//    {
//        $perPage = request()->query('per_page', $this->perPage());
//        $page    = request()->query('page');
//
//        $query = new School()->searchQuery(
//            request()->except('id', 'sort'),
//            request()->input('sort') ?? implode('|', School::SEARCH_ORDER_BY));
//
//        if (!empty($page)) {
//            $schools = $query->paginate($perPage)->appends(request()->except('page'));
//        } else {
//            $schools = $query->get();
//        }
//
//        return new SchoolCollection($schools)->response();
//    }

    /**
     * Display the specified portfolio school.
     *
     * @param School $school
     * @return JsonResponse
     */
    public function show(School $school): JsonResponse
    {
        return new SchoolResource($school)->response();
    }
}
