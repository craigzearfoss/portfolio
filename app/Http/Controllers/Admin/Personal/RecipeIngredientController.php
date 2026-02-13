<?php

namespace App\Http\Controllers\Admin\Personal;

use App\Enums\PermissionEntityTypes;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Personal\StoreRecipeIngredientsRequest;
use App\Http\Requests\Personal\UpdateRecipeIngredientsRequest;
use App\Models\Dictionary\Framework;
use App\Models\Personal\Ingredient;
use App\Models\Personal\Recipe;
use App\Models\Personal\RecipeIngredient;
use App\Models\System\Owner;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
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
     */
    public function index(Request $request): View
    {
        readGate(PermissionEntityTypes::RESOURCE, 'recipe-ingredient', $this->admin);

        $perPage = $request->query('per_page', $this->perPage());

        $query = RecipeIngredient::searchQuery($request->all(), !empty($this->owner->root) ? null : $this->owner)
            ->orderBy('recipe_id', 'asc');
        if ($recipe = $request->recipe_id ? Recipe::findOrFail($request->recipe_id) : null) {
            $query->where('recipe_id', $recipe->id);
        }
        $recipeIngredients = $query->paginate($perPage)->appends(request()->except('page'));

        $pageTitle = ($this->isRootAdmin && !empty($this->owner_id)) ? $this->owner->name . ' Recipe Ingredients' : 'Recipe Ingredients';

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
        createGate(PermissionEntityTypes::RESOURCE, 'recipe-ingredient', $this->admin);

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
        createGate(PermissionEntityTypes::RESOURCE, 'recipe-ingredient', $this->admin);

        $recipeIngredient = RecipeIngredient::create($request->validated());

        return redirect()->route('admin.personal.recipe-ingredient.show', $recipeIngredient)
            ->with('success', 'Recipe ingredient successfully added.');
    }

    /**
     * Display the specified recipe ingredient.
     *
     * @param RecipeIngredient $recipeIngredient
     * @return View
     */
    public function show(RecipeIngredient $recipeIngredient): View
    {
        readGate(PermissionEntityTypes::RESOURCE, $recipeIngredient, $this->admin);

        list($prev, $next) = Ingredient::prevAndNextPages($recipeIngredient->id,
            'admin.personal.recipe-ingredient.show',
            $this->owner->id ?? null,
            ['id', 'asc']);

        return view('admin.personal.recipe-ingredient.show', compact('recipeIngredient', 'prev', 'next'));
    }

    /**
     * Show the form for editing the specified recipe ingredient.
     *
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $recipeIngredient = RecipeIngredient::findOrFail($id);

        updateGate(PermissionEntityTypes::RESOURCE, $recipeIngredient, $this->admin);

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

        updateGate(PermissionEntityTypes::RESOURCE, $recipeIngredient, $this->admin);

        return redirect()->route('admin.personal.recipe-ingredient.show', $recipeIngredient)
            ->with('success', 'Recipe ingredient successfully updated.');
    }

    /**
     * Remove the specified recipe ingredient from storage.
     *
     * @param RecipeIngredient $recipeIngredient
     * @return RedirectResponse
     */
    public function destroy(RecipeIngredient $recipeIngredient): RedirectResponse
    {
        deleteGate(PermissionEntityTypes::RESOURCE, $recipeIngredient, $this->admin);

        $recipeIngredient->delete();

        return redirect(referer('admin.personal.recipe-ingredient.index'))
            ->with('success', 'Recipe ingredient deleted successfully.');
    }
}
