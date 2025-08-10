<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PortfolioRecipeStoreRequest;
use App\Http\Requests\PortfolioRecipeUpdateRequest;
use App\Models\Portfolio\Recipe;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PortfolioRecipeController extends Controller
{
    const NUM_PER_PAGE = 20;

    /**
     * Display a listing of the recipe.
     */
    public function index(): View
    {
        $recipes = Recipe::latest()->paginate(self::NUM_PER_PAGE);

        return view('admin.recipe.index', compact('recipes'))
            ->with('i', (request()->input('page', 1) - 1) * self::NUM_PER_PAGE);
    }

    /**
     * Show the form for creating a new recipe.
     */
    public function create(): View
    {
        return view('admin.recipe.create');
    }

    /**
     * Store a newly created recipe in storage.
     */
    public function store(PortfolioRecipeStoreRequest $request): RedirectResponse
    {
        Recipe::create($request->validated());

        return redirect()->route('admin.recipe.index')
            ->with('success', 'Recipe created successfully.');
    }

    /**
     * Display the specified recipe.
     */
    public function show(Recipe $recipe): View
    {
        return view('admin.recipe.show', compact('recipe'));
    }

    /**
     * Show the form for editing the specified recipe.
     */
    public function edit(Recipe $recipe): View
    {
        return view('admin.recipe.edit', compact('recipe'));
    }

    /**
     * Update the specified recipe in storage.
     */
    public function update(PortfolioRecipeUpdateRequest $request, Recipe $recipe): RedirectResponse
    {
        $recipe->update($request->validated());

        return redirect()->route('admin.recipe.index')
            ->with('success', 'Recipe updated successfully');
    }

    /**
     * Remove the specified recipe from storage.
     */
    public function destroy(Recipe $recipe): RedirectResponse
    {
        $recipe->delete();

        return redirect()->route('admin.recipe.index')
            ->with('success', 'Recipe deleted successfully');
    }
}
