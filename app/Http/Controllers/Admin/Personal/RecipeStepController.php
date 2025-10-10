<?php

namespace App\Http\Controllers\Admin\Personal;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Personal\StoreRecipeStepRequest;
use App\Http\Requests\Personal\UpdateRecipeStepRequest;
use App\Models\Personal\Recipe;
use App\Models\Personal\RecipeStep;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
        $perPage = $request->query('per_page', $this->perPage);

        if ($recipeId = $request->query('recipe_id')) {
            if (!$recipe = Recipe::find($recipeId)) {
                throw new NotFoundHttpException('Recipe not found.');
            } else {
                $recipeSteps = RecipeStep::where('recipe_id', $recipeId)->orderBy('step', 'asc')->paginate($perPage);
            }
        } else {
            $recipe = null;
            $recipeSteps = RecipeStep::latest()->paginate($perPage);
        }

        return view('admin.personal.recipe-step.index', compact('recipeSteps', 'recipeId'))
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
     * @param StoreRecipeStepRequest $storeRecipeStepStoreRequest
     * @return RedirectResponse
     */
    public function store(StoreRecipeStepRequest $storeRecipeStepStoreRequest): RedirectResponse
    {
        $recipeStep = RecipeStep::create($storeRecipeStepStoreRequest->validated());

        return redirect(referer('admin.personal.recipe-step.index')
            ->with('success', 'Recipe step added successfully.'));
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
        return view('admin.personal.recipe-step.edit', compact('recipeStep'));
    }

    /**
     * Update the specified recipe step in storage.
     *
     * @param UpdateRecipeStepRequest $updateRecipeStepRequest
     * @param RecipeStep $recipeStep
     * @return RedirectResponse
     */
    public function update(UpdateRecipeStepRequest $updateRecipeStepRequest, RecipeStep $recipeStep): RedirectResponse
    {
        $recipeStep->update($updateRecipeStepRequest->validated());

        return redirect(referer('admin.personal.recipe-step.index'))
            ->with('success', 'Recipe step updated successfully.');
    }

    /**
     * Remove the specified recipe step from storage.
     *
     * @param RecipeStep $recipeStep
     * @return RedirectResponse
     */
    public function destroy(RecipeStep $recipeStep): RedirectResponse
    {
        $recipeStep->delete();

        return redirect(referer('admin.personal.recipe-step.index'))
            ->with('success', 'Recipe step deleted successfully.');
    }
}
