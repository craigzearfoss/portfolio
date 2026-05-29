<?php

namespace App\Http\Controllers\Api\V1\Personal;

use App\Http\Controllers\Controller;
use App\Models\Personal\Recipe;
use App\Traits\GuestControllerTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 *
 */
class RecipeController extends Controller
{
    use GuestControllerTrait;

    /**
     * Display the personal recipes for the specified admin.
     *
     * @param string $owner_id
     * @return JsonResponse
     * @throws Exception
     */
    public function show(string $owner_id): JsonResponse
    {
        $perPage = request()->query('per_page', $this->perPage());
        $page    = request()->query('page');

        $query = new Recipe()->searchQuery(
            request()->except('id'),
            request()->input('sort') ?? implode('|', Recipe::SEARCH_ORDER_BY))
        ->where('recipes.owner_id', $owner_id);

        if (!empty($page)) {
            $recipes = $query->paginate($perPage)->appends(request()->except('page'));
        } else {
            $recipes = $query->get();
        }

        return response()->json($recipes)->setStatusCode(Response::HTTP_OK);
    }
}
