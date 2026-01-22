<?php

namespace App\Http\Controllers\Admin\Personal;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Personal\StoreRecipeStepsRequest;
use App\Http\Requests\Personal\UpdateRecipeStepsRequest;
use App\Models\Personal\Recipe;
use App\Models\Personal\RecipeStep;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
        $perPage = $request->query('per_page', $this->perPage());

        if ($recipeId = $request->recipe_id) {
            $recipe = !empty($this->owner)
                ? Recipe::where('owner_id', $this->owner->id)->where('id', $recipeId)->first()
                : Recipe::find($recipeId);
            if (empty($recipe)) {
                abort(404, 'Recipe ' . $recipeId . ' not found'
                    . (!empty($this->owner) ? ' for ' . $this->owner->username : '') . '.');
            } else {
                $recipeSteps = RecipeStep::where('recipe_id', $recipeId)->latest()->paginate($perPage);
            }
        } else {
            $recipe = null;
            $recipeSteps = RecipeStep::latest()->paginate($perPage);
        }

        $pageTitle = empty($this->owner) ? 'Recipe Steps' : $this->owner->name . ' Recipe Steps';

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
        $recipeStep = RecipeStep::create($request->validated());

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
        return view('admin.personal.recipe-step.show', compact('recipeStep'));
    }

    /**
     * Show the form for editing the specified recipe step.
     *
     * @param RecipeStep $recipeStep
     * @return View
     */
    public function edit(RecipeStep $recipeStep): View
    {
        Gate::authorize('update-resource', $recipeStep);

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
        Gate::authorize('update-resource', $recipeStep);

        $recipeStep->update($request->validated());

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
        Gate::authorize('delete-resource', $recipeStep);

        $recipeStep->delete();

        return redirect(referer('admin.personal.recipe-step.index'))
            ->with('success', 'Recipe step deleted successfully.');
    }
}
