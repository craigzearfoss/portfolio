<?php

namespace App\Http\Controllers\Api\V1\Portfolio;

use App\Http\Controllers\Controller;
use App\Http\Resources\Portfolio\AcademyCollection;
use App\Http\Resources\Portfolio\AcademyResource;
use App\Models\Portfolio\Academy;
use App\Traits\GuestControllerTrait;
use Exception;
use Illuminate\Http\JsonResponse;

/**
 *
 */
class AcademyController extends Controller
{
    use GuestControllerTrait;

    /**
     * Display a listing of portfolio academies.
     * @throws Exception
     */
    public function index(): JsonResponse
    {
        $perPage = request()->query('per_page', $this->perPage());
        $page    = request()->query('page');

        $query = new Academy()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', Academy::SEARCH_ORDER_BY));

        if (!empty($page)) {
            $academies = $query->paginate($perPage)->appends(request()->except('page'));
        } else {
            $academies = $query->get();
        }

        return new AcademyCollection($academies)->response();
    }

    /**
     * Display the specified portfolio academy.
     *
     * @param Academy $academy
     * @return JsonResponse
     */
    public function show(Academy $academy): JsonResponse
    {
        return new AcademyResource($academy)->response();
    }
}
