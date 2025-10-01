<?php

namespace App\Http\Controllers\Admin\Personal;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Personal\RecipeIngredientStoreRequest;
use App\Http\Requests\Personal\RecipeIngredientUpdateRequest;
use App\Models\Personal\RecipeIngredient;
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

        if ($recipeId = $request->query('recipe_id')) {
            $recipeIngredients = RecipeIngredient::where('recipe_id', $recipeId)->orderBy('sequence', 'asc')->paginate($perPage);
        } else {
            $recipeIngredients = RecipeIngredient::latest()->paginate($perPage);
        }

        return view('admin.personal.recipe-ingredient.index', compact('recipeIngredients', 'recipeId'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new recipe ingredient.
     *
     * @return View
     */
    public function create(): View
    {
        return view('admin.personal.recipe-ingredient.create');
    }

    /**
     * Store a newly created recipe ingredient in storage.
     *
     * @param RecipeIngredientStoreRequest $recipeIngredientStoreRequest
     * @return RedirectResponse
     */
    public function store(RecipeIngredientStoreRequest $recipeIngredientStoreRequest): RedirectResponse
    {
        $recipeIngredient = RecipeIngredient::create($recipeIngredientStoreRequest->validated());

        return redirect(referer('admin.personal.recipe-ingredient.index'))
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
        return view('admin.personal.recipe-ingredient.show', compact('recipeIngredient'));
    }

    /**
     * Show the form for editing the specified recipe ingredient.
     *
     * @param RecipeIngredient $recipeIngredient
     * @return View
     */
    public function edit(RecipeIngredient $recipeIngredient): View
    {
        return view('admin.personal.recipe-ingredient.edit', compact('recipeIngredient'));
    }

    /**
     * Update the specified recipe ingredient in storage.
     *
     * @param RecipeIngredientUpdateRequest $recipeIngredientUpdateRequest
     * @param RecipeIngredient $recipeIngredient
     * @return RedirectResponse
     */
    public function update(RecipeIngredientUpdateRequest $recipeIngredientUpdateRequest,
                           RecipeIngredient  $recipeIngredient): RedirectResponse
    {
        $recipeIngredient->update($recipeIngredientUpdateRequest->validated());

        return redirect(referer('admin.personal.recipe-ingredient.index'))
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

        return redirect(referer('admin.personal.recipe-ingredient.index'))
            ->with('success', 'Recipe ingredient deleted successfully.');
    }
}
