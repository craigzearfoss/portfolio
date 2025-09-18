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
     * @param Request $request
     * @return View
     */
    public function create(Request $request): View
    {
        $referer = $request->headers->get('referer');

        return view('admin.portfolio.recipe-ingredient.create', compact('referer'));
    }

    /**
     * Store a newly created recipe ingredient in storage.
     *
     * @param RecipeStoreRequest $request
     * @return RedirectResponse
     */
    public function store(RecipeIngredientStoreRequest $request): RedirectResponse
    {
        $recipeIngredient = RecipeIngredient::create($request->validated());

        $referer = $request->input('referer');

        if (!empty($referer)) {
            return redirect(str_replace(config('app.url'), '', $referer))
                ->with('success', 'Recipe ingredient created successfully.');
        } else {
        return redirect()->route('admin.portfolio.recipe-ingredient.index')
            ->with('success', 'Recipe ingredient created successfully.');
        }
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
     * @param Request $request
     * @return View
     */
    public function edit(RecipeIngredient $recipeIngredient, Request $request): View
    {
        $referer = $request->headers->get('referer');

        return view('admin.portfolio.recipe-ingredient.edit', compact('recipeIngredient', 'referer'));
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

        $referer = $request->input('referer');

        if (!empty($referer)) {
            return redirect(str_replace(config('app.url'), '', $referer))
                ->with('success', 'Recipe ingredient updated successfully.');
        } else {
            return redirect()->route('admin.portfolio.recipe-ingredient.index')
                ->with('success', 'Recipe ingredient updated successfully.');
        }
    }

    /**
     * Remove the specified recipe ingredient from storage.
     *
     * @param RecipeIngredient $recipeIngredient
     * @param Request $request
     * @return RedirectResponse
     */
    public function destroy(RecipeIngredient $recipeIngredient, Request $request): RedirectResponse
    {
        $recipeIngredient->delete();

        $referer = $request->input('referer');

        if (!empty($referer)) {
            return redirect(str_replace(config('app.url'), '', $referer))
                ->with('success', 'Recipe ingredient deleted successfully.');
        } else {
            return redirect()->route('admin.portfolio.recipe-ingredient.index')
                ->with('success', 'Recipe ingredient deleted successfully.');
        }
    }
}
