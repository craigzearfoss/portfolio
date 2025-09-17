<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\BaseController;
use App\Models\Portfolio\Recipe;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 *
 */
class RecipeController extends BaseController
{
    /**
     * Display a listing of recipes.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $perPage = $request->query('per_page', $this->perPage);

        $recipes = Recipe::where('public', 1)
            ->where('disabled', 0)
            ->orderBy('sequence', 'asc')
            ->paginate($perPage);

        $title = 'Recipes';
        return view('front.recipe.index', compact('recipes', 'title'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Display the specified recipe.
     *
     * @param string $slug
     * @return View
     */
    public function show(string $slug): View
    {
        if (!$recipe = Recipe::where('slug', $slug)->first()) {
            throw new ModelNotFoundException();
        }

        return view('front.recipe.show', compact('recipe'));
    }
}
