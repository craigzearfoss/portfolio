<?php

namespace App\Http\Controllers\Admin\Personal;

use App\Enums\PermissionEntityTypes;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Personal\StoreRecipesRequest;
use App\Http\Requests\Personal\UpdateRecipesRequest;
use App\Models\Personal\Recipe;
use App\Models\System\Owner;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
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
        readGate(PermissionEntityTypes::RESOURCE, 'recipe', $this->admin);

        $perPage = $request->query('per_page', $this->perPage());

        $recipes = Recipe::searchQuery($request->all(), !empty($this->owner->root) ? null : $this->owner)
            ->orderBy('owner_id')
            ->orderBy('name')
            ->paginate($perPage)->appends(request()->except('page'));

        $pageTitle = ($this->isRootAdmin && !empty($owner_id)) ? $this->owner->name . ' Recipes' : 'Recipes';

        return view('admin.personal.recipe.index', compact('recipes', 'pageTitle'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new recipe.
     *
     * @return View
     */
    public function create(): View
    {
        createGate(PermissionEntityTypes::RESOURCE, 'recipe', $this->admin);

        return view('admin.personal.recipe.create');
    }

    /**
     * Store a newly created recipe in storage.
     *
     * @param StoreRecipesRequest $request
     * @return RedirectResponse
     */
    public function store(StoreRecipesRequest $request): RedirectResponse
    {
        createGate(PermissionEntityTypes::RESOURCE, 'recipe', $this->admin);

        $recipe = new Recipe()->create($request->validated());

        return redirect()->route('admin.personal.recipe.show', $recipe)
            ->with('success', $recipe->name . ' successfully added.');
    }

    /**
     * Display the specified recipe.
     *
     * @param Recipe $recipe
     * @return View
     */
    public function show(Recipe $recipe): View
    {
        readGate(PermissionEntityTypes::RESOURCE, $recipe, $this->admin);

        list($prev, $next) = Recipe::prevAndNextPages($recipe->id,
            'admin.personal.recipe.show',
            $this->owner->id ?? null,
            ['name', 'asc']);

        return view('admin.personal.recipe.show', compact('recipe', 'prev', 'next'));
    }

    /**
     * Show the form for editing the specified recipe.
     *
     * @param Recipe $recipe
     * @return View
     */
    public function edit(Recipe $recipe): View
    {
        updateGate(PermissionEntityTypes::RESOURCE, $recipe, $this->admin);

        return view('admin.personal.recipe.edit', compact('recipe'));
    }

    /**
     * Update the specified recipe in storage.
     *
     * @param UpdateRecipesRequest $request
     * @param Recipe $recipe
     * @return RedirectResponse
     */
    public function update(UpdateRecipesRequest $request, Recipe $recipe): RedirectResponse
    {
        $recipe->update($request->validated());

        updateGate(PermissionEntityTypes::RESOURCE, $recipe, $this->admin);

        return redirect()->route('admin.personal.recipe.show', $recipe)
            ->with('success', $recipe->name . ' successfully updated.');
    }

    /**
     * Remove the specified recipe from storage.
     *
     * @param Recipe $recipe
     * @return RedirectResponse
     */
    public function destroy(Recipe $recipe): RedirectResponse
    {
        deleteGate(PermissionEntityTypes::RESOURCE, $recipe, $this->admin);

        $recipe->delete();

        return redirect(referer('admin.personal.recipe.index'))
            ->with('success', $recipe->name . ' deleted successfully.');
    }
}
