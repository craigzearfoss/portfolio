<?php

namespace App\Http\Controllers\Api\V1\Portfolio;

use App\Http\Controllers\Controller;
use App\Models\Portfolio\Education;
use App\Traits\GuestControllerTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 *
 */
class EducationController extends Controller
{
    use GuestControllerTrait;

    /**
     * Display the portfolio education for the specified admin.
     *
     * @param string $owner_id
     * @return JsonResponse
     * @throws Exception
     */
    public function show(string $owner_id): JsonResponse
    {
        $perPage = request()->query('per_page', $this->perPage());
        $page    = request()->query('page');

        $query = new Education()->searchQuery(
            request()->except('id'),
            request()->input('sort') ?? implode('|', Education::SEARCH_ORDER_BY))
        ->where('educations.owner_id', $owner_id);

        if (!empty($page)) {
            $educations = $query->paginate($perPage)->appends(request()->except('page'));
        } else {
            $educations = $query->get();
        }

        return response()->json($educations)->setStatusCode(Response::HTTP_OK);
    }
}
