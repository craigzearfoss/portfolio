<?php

namespace App\Http\Controllers\Api\V1\Portfolio;

use App\Http\Controllers\Controller;
use App\Models\Portfolio\Skill;
use App\Traits\GuestControllerTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 *
 */
class SkillController extends Controller
{
    use GuestControllerTrait;

    /**
     * Display the portfolio skills for the specified admin.
     *
     * @param string $owner_id
     * @return JsonResponse
     * @throws Exception
     */
    public function show(string $owner_id): JsonResponse
    {
        $perPage = request()->query('per_page', $this->perPage());
        $page    = request()->query('page');

        $query = new Skill()->searchQuery(
            request()->except('id'),
            request()->input('sort') ?? implode('|', Skill::SEARCH_ORDER_BY))
        ->where('skills.owner_id', $owner_id);

        if (!empty($page)) {
            $skills = $query->paginate($perPage)->appends(request()->except('page'));
        } else {
            $skills = $query->get();
        }

        return response()->json($skills)->setStatusCode(Response::HTTP_OK);
    }
}
