<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Http\Controllers\Controller;
use App\Http\Requests\PortfolioRecipeIngredientStoreRequest;
use App\Http\Requests\PortfolioRecipeIngredientUpdateRequest;
use App\Models\Portfolio\RecipeIngredient;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RecipeIngredientController extends Controller
{
    const NUM_PER_PAGE = 20;

    /**
     * Display a listing of recipe ingredients.
     */
    public function index(): View
    {
        $recipeIngredients = RecipeIngredient::latest()->paginate(self::NUM_PER_PAGE);

        return view('admin.recipe_ingredient.index', compact('recipeIngredients'))
            ->with('i', (request()->input('page', 1) - 1) * self::NUM_PER_PAGE);
    }

    /**
     * Show the form for creating a new recipe ingredient.
     */
    public function create(): View
    {
        return view('admin.recipe_ingredient.create');
    }

    /**
     * Store a newly created recipe ingredient in storage.
     */
    public function store(PortfolioRecipeIngredientStoreRequest $request): RedirectResponse
    {
        RecipeIngredient::create($request->validated());

        return redirect()->route('admin.recipe_ingredient.index')
            ->with('success', 'Recipe ingredient created successfully.');
    }

    /**
     * Display the specified recipe ingredient.
     */
    public function show(RecipeIngredient $recipeIngredient): View
    {
        return view('admin.recipe_ingredient.show', compact('recipeIngredient'));
    }

    /**
     * Show the form for editing the specified recipe ingredient.
     */
    public function edit(RecipeIngredient $recipeIngredient): View
    {
        return view('admin.recipe_ingredient.edit', compact('recipeIngredient'));
    }

    /**
     * Update the specified recipe ingredient in storage.
     */
    public function update(PortfolioRecipeIngredientUpdateRequest $request,
                           RecipeIngredient $recipeIngredient): RedirectResponse
    {
        $recipeIngredient->update($request->validated());

        return redirect()->route('admin.recipe_ingredient.index')
            ->with('success', 'Recipe ingredient updated successfully');
    }

    /**
     * Remove the specified recipe ingredient from storage.
     */
    public function destroy(RecipeIngredient $recipeIngredient): RedirectResponse
    {
        $recipeIngredient->delete();

        return redirect()->route('admin.recipe_ingredient.index')
            ->with('success', 'Recipe ingredient deleted successfully');
    }
}
