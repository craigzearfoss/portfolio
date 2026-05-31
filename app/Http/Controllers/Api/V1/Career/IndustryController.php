<?php

namespace App\Http\Controllers\Api\V1\Career;

use App\Http\Controllers\Controller;
use App\Http\Resources\Career\IndustryCollection;
use App\Http\Resources\Career\IndustryResource;
use App\Models\Career\Industry;
use App\Traits\GuestControllerTrait;
use Exception;
use Illuminate\Http\JsonResponse;

/**
 *
 */
class IndustryController extends Controller
{
    use GuestControllerTrait;

    /**
     * Display a listing of career industries.
     * @throws Exception
     */
    public function index(): JsonResponse
    {
        $perPage = request()->query('per_page', $this->perPage());
        $page    = request()->query('page');

        $query = new Industry()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', Industry::SEARCH_ORDER_BY));

        if (!empty($page)) {
            $industries = $query->paginate($perPage)->appends(request()->except('page'));
        } else {
            $industries = $query->get();
        }

        return new IndustryCollection($industries)->response();
    }

    /**
     * Display the specified career industry.
     *
     * @param Industry $industry
     * @return JsonResponse
     */
    public function show(Industry $industry): JsonResponse
    {
        return new IndustryResource($industry)->response();
    }
}
