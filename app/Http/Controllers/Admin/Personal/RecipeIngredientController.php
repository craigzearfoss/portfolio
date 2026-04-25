<?php

namespace App\Http\Controllers\Admin\Personal;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Personal\StoreRecipeIngredientsRequest;
use App\Http\Requests\Personal\UpdateRecipeIngredientsRequest;
use App\Models\Personal\Recipe;
use App\Models\Personal\RecipeIngredient;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 *
 */
class RecipeIngredientController extends BaseAdminController
{
    /**
     * Display a listing of recipe ingredients.
     *
     * @param Request $request
     * @return View
     * @throws Exception
     */
    public function index(Request $request): View
    {
        readGate(RecipeIngredient::class, $this->admin);

        $perPage = $request->query('per_page', $this->perPage());

        $recipeIngredients = new RecipeIngredient()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', RecipeIngredient::SEARCH_ORDER_BY),
            $this->singleAdminMode || !$this->isRootAdmin ? $this->admin : null
        )
        ->paginate($perPage)->appends(request()->except('page'));

        $recipe = $request->recipe_id ? Recipe::query()->findOrFail($request->recipe_id) : null;

        $pageTitle = ($this->owner->name  ?? '') . ' Recipe Ingredients';

        return view('admin.personal.recipe-ingredient.index', compact('recipeIngredients', 'recipe', 'pageTitle'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new recipe ingredient.
     *
     * @return View
     */
    public function create(): View
    {
        createGate(RecipeIngredient::class, $this->admin);

        return view('admin.personal.recipe-ingredient.create');
    }

    /**
     * Store a newly created recipe ingredient in storage.
     *
     * @param StoreRecipeIngredientsRequest $request
     * @return RedirectResponse
     */
    public function store(StoreRecipeIngredientsRequest $request): RedirectResponse
    {
        createGate(RecipeIngredient::class, $this->admin);

        $recipeIngredient = RecipeIngredient::query()->create($request->validated());

        if ($referer = $request->input('referer')) {
            return redirect($referer)->with('success', 'Recipe ingredient successfully added.');
        } else {
            return redirect()->route('admin.personal.recipe-ingredient.show', $recipeIngredient)
                ->with('success', 'Recipe ingredient successfully added.');
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
        readGate($recipeIngredient, $this->admin);

        list($prev, $next) = $recipeIngredient->prevAndNextPages(
            $recipeIngredient['id'],
            'admin.personal.recipe-ingredient.show',
            $this->owner ?? null
        );

        return view('admin.personal.recipe-ingredient.show', compact('recipeIngredient', 'prev', 'next'));
    }

    /**
     * Show the form for editing the specified recipe ingredient.
     *
     * @param RecipeIngredient $recipeIngredient
     * @return View
     */
    public function edit(RecipeIngredient $recipeIngredient): View
    {
        updateGate($recipeIngredient, $this->admin);

        return view('admin.personal.recipe-ingredient.edit', compact('recipeIngredient'));
    }

    /**
     * Update the specified recipe ingredient in storage.
     *
     * @param UpdateRecipeIngredientsRequest $request
     * @param RecipeIngredient $recipeIngredient
     * @return RedirectResponse
     */
    public function update(UpdateRecipeIngredientsRequest $request,
                           RecipeIngredient               $recipeIngredient): RedirectResponse
    {
        $recipeIngredient->update($request->validated());

        updateGate($recipeIngredient, $this->admin);

        if ($referer = $request->input('referer')) {
            return redirect($referer)->with('success', 'Recipe ingredient successfully updated.');
        } else {
            return redirect()->route('admin.personal.recipe-ingredient.show', $recipeIngredient)
                ->with('success', 'Recipe ingredient successfully updated.');
        }
    }

    /**
     * Remove the specified recipe ingredient from storage.
     *
     * @param RecipeIngredient $recipeIngredient
     * @return RedirectResponse
     */
    public function destroy(RecipeIngredient $recipeIngredient): RedirectResponse
    {
        deleteGate($recipeIngredient, $this->admin);

        $recipeIngredient->delete();

        return redirect(referer('admin.personal.recipe-ingredient.index'))
            ->with('success', 'Recipe ingredient deleted successfully.');
    }
}
