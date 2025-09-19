<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Portfolio\RecipeIngredientStoreRequest;
use App\Http\Requests\Portfolio\RecipeIngredientUpdateRequest;
use App\Models\Portfolio\RecipeIngredient;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 *
 */
class RecipeIngredientController extends BaseController
{
    /**
     * Display a listing of recipe ingredients.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $perPage = $request->query('per_page', $this->perPage);

        $recipeIngredients = RecipeIngredient::latest()->paginate($perPage);

        return view('admin.portfolio.recipe-ingredient.index', compact('recipeIngredients'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new recipe ingredient.
     *
     * @return View
     */
    public function create(): View
    {
        return view('admin.portfolio.recipe-ingredient.create');
    }

    /**
     * Store a newly created recipe ingredient in storage.
     *
     * @param RecipeIngredientStoreRequest $request
     * @return RedirectResponse
     */
    public function store(RecipeIngredientStoreRequest $request): RedirectResponse
    {
        $recipeIngredient = RecipeIngredient::create($request->validated());

        return redirect(referer('admin.portfolio.recipe-ingredient.index'))
            ->with('success', 'Recipe ingredient added successfully.');
    }

    /**
     * Display the specified recipe ingredient.
     *
     * @param RecipeIngredient $recipeIngredient
     * @return View
     */
    public function show(RecipeIngredient $recipeIngredient): View
    {
        return view('admin.portfolio.recipe-ingredient.show', compact('recipeIngredient'));
    }

    /**
     * Show the form for editing the specified recipe ingredient.
     *
     * @param RecipeIngredient $recipeIngredient
     * @return View
     */
    public function edit(RecipeIngredient $recipeIngredient): View
    {
        return view('admin.portfolio.recipe-ingredient.edit', compact('recipeIngredient'));
    }

    /**
     * Update the specified recipe ingredient in storage.
     *
     * @param RecipeIngredientUpdateRequest $request
     * @param RecipeIngredient $recipeIngredient
     * @return RedirectResponse
     */
    public function update(RecipeIngredientUpdateRequest $request,
                           RecipeIngredient  $recipeIngredient): RedirectResponse
    {
        $recipeIngredient->update($request->validated());

        return redirect(referer('admin.portfolio.recipe-ingredient.index'))
            ->with('success', 'Recipe ingredient updated successfully.');
    }

    /**
     * Remove the specified recipe ingredient from storage.
     *
     * @param RecipeIngredient $recipeIngredient
     * @return RedirectResponse
     */
    public function destroy(RecipeIngredient $recipeIngredient): RedirectResponse
    {
        $recipeIngredient->delete();

        return redirect(referer('admin.portfolio.recipe-ingredient.index'))
            ->with('success', 'Recipe ingredient deleted successfully.');
    }
}
