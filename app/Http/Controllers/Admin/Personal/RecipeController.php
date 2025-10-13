<?php

namespace App\Http\Controllers\Admin\Personal;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Personal\StoreRecipesRequest;
use App\Http\Requests\Personal\UpdateRecipesRequest;
use App\Models\Personal\Recipe;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 *
 */
class RecipeController extends BaseAdminController
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
     * @param StoreRecipesRequest $storeRecipesRequest
     * @return RedirectResponse
     */
    public function store(StoreRecipesRequest $storeRecipesRequest): RedirectResponse
    {
        $recipe = Recipe::create($storeRecipesRequest->validated());

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
     * @param UpdateRecipesRequest $updateRecipesRequest
     * @param Recipe $recipe
     * @return RedirectResponse
     */
    public function update(UpdateRecipesRequest $updateRecipesRequest, Recipe $recipe): RedirectResponse
    {
        $recipe->update($updateRecipesRequest->validated());

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
