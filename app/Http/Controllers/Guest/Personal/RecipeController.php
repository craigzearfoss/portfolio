<?php

namespace App\Http\Controllers\Guest\Personal;

use App\Http\Controllers\Guest\BaseGuestController;
use App\Models\Personal\Recipe;
use App\Models\Personal\RecipeStep;
use App\Models\System\Admin;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 *
 */
class RecipeController extends BaseGuestController
{
    /**
     * Display a listing of recipes.
     *
     * @param Admin $admin
     * @param Request $request
     * @return View
     */
    public function index(Admin $admin, Request $request): View
    {
        $perPage = $request->query('per_page', $this->perPage);

        $recipes = Recipe::where('owner_id', $admin->id)
            ->orderBy('name', 'asc')
            ->paginate($perPage);

        return view(themedTemplate('guest.personal.recipe.index'), compact('recipes', 'admin'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Display the specified recipe.
     *
     * @param Admin $admin
     * @param string $slug
     * @return View
     */
    public function show(Admin $admin, string $slug): View
    {
        if (!$recipe = Recipe::where('owner_id', $admin->id)->where('slug', $slug)->first()) {
            throw new ModelNotFoundException();
        }

        //$recipeSteps = RecipeStep::where('recipe_id', $recipe->id)->orderBy('step', 'asc')->ddRawSql();
        //dd($recipe);
        return view(themedTemplate('guest.personal.recipe.show'), compact('recipe', 'admin'));
    }
}
