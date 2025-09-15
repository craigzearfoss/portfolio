<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Portfolio\RecipeStoreRequest;
use App\Http\Requests\Portfolio\RecipeUpdateRequest;
use App\Models\Portfolio\Recipe;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

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
        $perPage= $request->query('per_page', $this->perPage);

        $recipes = Recipe::orderBy('name', 'asc')->paginate($perPage);

        return view('admin.portfolio.recipe.index', compact('recipes'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new recipe.
     */
    public function create(): View
    {
        return view('admin.portfolio.recipe.create');
    }

    /**
     * Store a newly created recipe in storage.
     */
    public function store(RecipeStoreRequest $request): RedirectResponse
    {
        Recipe::create($request->validated());

        return redirect()->route('admin.portfolio.recipe.index')
            ->with('success', 'Recipe created successfully.');
    }

    /**
     * Display the specified recipe.
     */
    public function show(Recipe $recipe): View
    {
        return view('admin.portfolio.recipe.show', compact('recipe'));
    }

    /**
     * Show the form for editing the specified recipe.
     */
    public function edit(Recipe $recipe): View
    {
        return view('admin.portfolio.recipe.edit', compact('recipe'));
    }

    /**
     * Update the specified recipe in storage.
     */
    public function update(RecipeUpdateRequest $request, Recipe $recipe): RedirectResponse
    {
        $recipe->update($request->validated());

        return redirect()->route('admin.portfolio.recipe.index')
            ->with('success', 'Recipe updated successfully');
    }

    /**
     * Remove the specified recipe from storage.
     */
    public function destroy(Recipe $recipe): RedirectResponse
    {
        $recipe->delete();

        return redirect()->route('admin.portfolio.recipe.index')
            ->with('success', 'Recipe deleted successfully');
    }
}
