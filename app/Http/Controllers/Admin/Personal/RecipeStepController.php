<?php

namespace App\Http\Controllers\Admin\Personal;

use App\Exports\Personal\RecipeStepsExport;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Personal\StoreRecipeStepsRequest;
use App\Http\Requests\Personal\UpdateRecipeStepsRequest;
use App\Models\Personal\Recipe;
use App\Models\Personal\RecipeStep;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

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
     * @throws Exception
     */
    public function index(Request $request): View
    {
        readGate(RecipeStep::class, $this->admin);

        $perPage = $request->query('per_page', $this->perPage());

        $recipeSteps = new RecipeStep()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', RecipeStep::SEARCH_ORDER_BY),
            !$this->isRootAdmin ? $this->admin : null
        )
        ->paginate($perPage)->appends(request()->except('page'));

        $recipe = $request->input('recipe_id')
            ? Recipe::query()->findOrFail($request->input('recipe_id'))
            : null;

        $pageTitle = ($this->owner->name  ?? '') . ' Recipe Steps';

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
        createGate(RecipeStep::class, $this->admin);

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
        createGate(RecipeStep::class, $this->admin);

        $recipeStep = RecipeStep::query()->create($request->validated());

        if ($referer = $request->input('referer')) {
            return redirect($referer)->with('success', 'Recipe step successfully added.');
        } else {
            return redirect()->route('admin.personal.recipe-step.show', $recipeStep)
                ->with('success', 'Recipe step successfully added.');
        }
    }

    /**
     * Display the specified recipe step.
     *
     * @param RecipeStep $recipeStep
     * @return View
     */
    public function show(RecipeStep $recipeStep): View
    {
        readGate($recipeStep, $this->admin);

        list($prev, $next) = $recipeStep->prevAndNextPages(
            $recipeStep['id'],
            'admin.personal.recipe-step.show',
            $this->owner ?? null,
        );

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
        updateGate( $recipeStep, $this->admin);

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

        updateGate($recipeStep, $this->admin);

        if ($referer = $request->input('referer')) {
            return redirect($referer)->with('success', 'Recipe step successfully updated.');
        } else {
            return redirect()->route('admin.personal.recipe-step.show', $recipeStep)
                ->with('success', 'Recipe step successfully updated.');
        }
    }

    /**
     * Remove the specified recipe step from storage.
     *
     * @param RecipeStep $recipeStep
     * @return RedirectResponse
     */
    public function destroy(RecipeStep $recipeStep): RedirectResponse
    {
        deleteGate($recipeStep, $this->admin);

        $recipeStep->delete();

        return redirect(referer('admin.personal.recipe-step.index'))
            ->with('success', 'Recipe step deleted successfully.');
    }

    /**
     * Export Microsoft Excel file.
     *
     * @return BinaryFileResponse
     */
    public function export(): BinaryFileResponse
    {
        readGate(RecipeStep::class, $this->admin);

        $filename = request()->has('timestamp')
            ? 'recipe_steps_' . date("Y-m-d-His") . '.xlsx'
            : 'recipe_steps.xlsx';

        return Excel::download(new RecipeStepsExport(), $filename);
    }
}
