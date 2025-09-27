<?php

namespace App\Http\Controllers\Admin\Personal;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Personal\RecipeStoreRequest;
use App\Http\Requests\Personal\RecipeUpdateRequest;
use App\Models\Personal\Recipe;
use Illuminate\Http\RedirectResponse;
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

        $recipes = Recipe::orderBy('name', 'asc')->paginate($perPage);

        return view('admin.personal.recipe.index', compact('recipes'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new recipe.
     *
     * @return View
     */
    public function create(): View
    {
        return view('admin.personal.recipe.create');
    }

    /**
     * Store a newly created recipe in storage.
     *
     * @param RecipeStoreRequest $request
     * @return RedirectResponse
     */
    public function store(RecipeStoreRequest $request): RedirectResponse
    {
        $recipe = Recipe::create($request->validated());

        return redirect(referer('admin.personal.recipe.index'))
            ->with('success', $recipe->name . ' added successfully.');
    }

    /**
     * Display the specified recipe.
     *
     * @param Recipe $recipe
     * @return View
     */
    public function show(Recipe $recipe): View
    {
        return view('admin.personal.recipe.show', compact('recipe'));
    }

    /**
     * Show the form for editing the specified recipe.
     *
     * @param Recipe $recipe
     * @return View
     */
    public function edit(Recipe $recipe): View
    {
        return view('admin.personal.recipe.edit', compact('recipe'));
    }

    /**
     * Update the specified recipe in storage.
     *
     * @param RecipeUpdateRequest $request
     * @param Recipe $recipe
     * @return RedirectResponse
     */
    public function update(RecipeUpdateRequest $request, Recipe $recipe): RedirectResponse
    {dd($recipe);
        $recipe->update($request->validated());

        return redirect(referer('admin.personal.recipe.index'))
            ->with('success', $recipe->name . ' updated successfully.');
    }

    /**
     * Remove the specified recipe from storage.
     *
     * @param Recipe $recipe
     * @return RedirectResponse
     */
    public function destroy(Recipe $recipe): RedirectResponse
    {
        $recipe->delete();

        return redirect(referer('admin.personal.recipe.index'))
            ->with('success', $recipe->name . ' deleted successfully.');
    }
}
