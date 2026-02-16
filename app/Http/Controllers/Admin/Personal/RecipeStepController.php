<?php

namespace App\Http\Controllers\Admin\Personal;

use App\Enums\PermissionEntityTypes;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Personal\StoreRecipeStepsRequest;
use App\Http\Requests\Personal\UpdateRecipeStepsRequest;
use App\Models\Personal\Recipe;
use App\Models\Personal\RecipeStep;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 *
 */
class RecipeStepController extends BaseAdminController
{
    /**
     * Display a listing of recipe steps.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        readGate(PermissionEntityTypes::RESOURCE, 'recipe-step', $this->admin);

        $perPage = $request->query('per_page', $this->perPage());

        $query = RecipeStep::searchQuery($request->all(), !empty($this->owner->root) ? null : $this->owner)
            ->orderBy('owner_id')
            ->orderBy('recipe_id');
        if ($recipe = $request->recipe_id ? new Recipe()->findOrFail($request->recipe_id) : null) {
            $query->where('recipe_id', $recipe->id);
        }
        $recipeSteps = $query->paginate($perPage)->appends(request()->except('page'));

        $pageTitle = ($this->isRootAdmin && !empty($this->owner_id)) ? $this->owner->name . ' Recipe Steps' : 'Recipe Steps';

        return view('admin.personal.recipe-step.index', compact('recipeSteps', 'recipe', 'pageTitle'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new recipe step.
     *
     * @return View
     */
    public function create(): View
    {
        createGate(PermissionEntityTypes::RESOURCE, 'recipe-step', $this->admin);

        return view('admin.personal.recipe-step.create');
    }

    /**
     * Store a newly created recipe step in storage.
     *
     * @param StoreRecipeStepsRequest $request
     * @return RedirectResponse
     */
    public function store(StoreRecipeStepsRequest $request): RedirectResponse
    {
        createGate(PermissionEntityTypes::RESOURCE, 'recipe-step', $this->admin);

        $recipeStep = new RecipeStep()->create($request->validated());

        return redirect()->route('admin.personal.recipe-step.show', $recipeStep)
            ->with('success', 'Recipe step successfully added.');
    }

    /**
     * Display the specified recipe step.
     *
     * @param RecipeStep $recipeStep
     * @return View
     */
    public function show(RecipeStep $recipeStep): View
    {
        readGate(PermissionEntityTypes::RESOURCE, $recipeStep, $this->admin);

        list($prev, $next) = RecipeStep::prevAndNextPages($recipeStep->id,
            'admin.personal.recipe-step.show',
            $this->owner->id ?? null);

        return view('admin.personal.recipe-step.show', compact('recipeStep', 'prev', 'next'));
    }

    /**
     * Show the form for editing the specified recipe step.
     *
     * @param RecipeStep $recipeStep
     * @return View
     */
    public function edit(RecipeStep $recipeStep): View
    {
        updateGate(PermissionEntityTypes::RESOURCE, $recipeStep, $this->admin);

        return view('admin.personal.recipe-step.edit', compact('recipeStep'));
    }

    /**
     * Update the specified recipe step in storage.
     *
     * @param UpdateRecipeStepsRequest $request
     * @param RecipeStep $recipeStep
     * @return RedirectResponse
     */
    public function update(UpdateRecipeStepsRequest $request, RecipeStep $recipeStep): RedirectResponse
    {
        $recipeStep->update($request->validated());

        updateGate(PermissionEntityTypes::RESOURCE, $recipeStep, $this->admin);

        return redirect()->route('admin.personal.recipe-step.show', $recipeStep)
            ->with('success', 'Recipe step successfully updated.');
    }

    /**
     * Remove the specified recipe step from storage.
     *
     * @param RecipeStep $recipeStep
     * @return RedirectResponse
     */
    public function destroy(RecipeStep $recipeStep): RedirectResponse
    {
        deleteGate(PermissionEntityTypes::RESOURCE, $recipeStep, $this->admin);

        $recipeStep->delete();

        return redirect(referer('admin.personal.recipe-step.index'))
            ->with('success', 'Recipe step deleted successfully.');
    }
}
