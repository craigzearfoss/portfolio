<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Portfolio\RecipeStoreRequest;
use App\Http\Requests\Portfolio\RecipeUpdateRequest;
use App\Models\Portfolio\Recipe;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
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

        return view('admin.portfolio.recipe.index', compact('recipes'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new recipe.
     *
     * @param Request $request
     * @return View
     */
    public function create(Request $request): View
    {
        $referer = $request->headers->get('referer');

        return view('admin.portfolio.recipe.create', compact('referer'));
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

        $referer = $request->input('referer');

        if (!empty($referer)) {
            return redirect(str_replace(config('app.url'), '', $referer))
                ->with('success', $recipe->name . ' created successfully.');
        } else {
            return redirect()->route('admin.portfolio.recipe.index')
                ->with('success', $recipe->name . ' created successfully.');
        }
    }

    /**
     * Display the specified recipe.
     *
     * @param Recipe $recipe
     * @return View
     */
    public function show(Recipe $recipe): View
    {
        return view('admin.portfolio.recipe.show', compact('recipe'));
    }

    /**
     * Show the form for editing the specified recipe.
     *
     * @param Recipe $recipe
     * @param Request $request
     * @return View
     */
    public function edit(Recipe $recipe, Request $request): View
    {
        $referer = $request->headers->get('referer');

        return view('admin.portfolio.recipe.edit', compact('recipe', 'referer'));
    }

    /**
     * Update the specified recipe in storage.
     *
     * @param RecipeUpdateRequest $request
     * @param Recipe $recipe
     * @return RedirectResponse
     */
    public function update(RecipeUpdateRequest $request, Recipe $recipe): RedirectResponse
    {
        $recipe->update($request->validated());

        $referer = $request->input('referer');

        if (!empty($referer)) {
            return redirect(str_replace(config('app.url'), '', $referer))
                ->with('success', $recipe->name . ' updated successfully.');
        } else {
            return redirect()->route('admin.portfolio.recipe.index')
                ->with('success', $recipe->name . ' updated successfully.');
        }
    }

    /**
     * Remove the specified recipe from storage.
     *
     * @param Recipe $recipe
     * @param Request $request
     * @return RedirectResponse
     */
    public function destroy(Recipe $recipe, Request $request): RedirectResponse
    {
        $recipe->delete();

        $referer = $request->input('referer');

        if (!empty($referer)) {
            return redirect(str_replace(config('app.url'), '', $referer))
                ->with('success', $recipe->name . ' deleted successfully.');
        } else {
            return redirect()->route('admin.portfolio.recipe.index')
                ->with('success', $recipe->name . ' deleted successfully.');
        }
    }
}
