<?php

namespace App\Http\Controllers\Api\V1\Personal;

use App\Http\Controllers\Controller;
use App\Http\Resources\Personal\RecipeCollection;
use App\Http\Resources\Personal\RecipeResource;
use App\Models\Personal\Recipe;
use App\Traits\GuestControllerTrait;
use Exception;
use Illuminate\Http\JsonResponse;

/**
 *
 */
class RecipeController extends Controller
{
    use GuestControllerTrait;

    /**
     * Display the specified personal recipe.
     *
     * @param Recipe $recipe
     * @return JsonResponse
     * @throws Exception
     */
    public function show(Recipe $recipe): JsonResponse
    {
        return new RecipeResource($recipe)->response();
    }
}
