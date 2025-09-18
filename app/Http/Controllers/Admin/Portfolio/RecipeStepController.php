<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Portfolio\RecipeStepStoreRequest;
use App\Http\Requests\Portfolio\RecipeStepUpdateRequest;
use App\Models\Portfolio\RecipeStep;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 *
 */
class RecipeStepController extends BaseController
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

        $recipeSteps = RecipeStep::latest()->paginate($perPage);

        return view('admin.portfolio.recipe-step.index', compact('recipeSteps'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new recipe step.
     *
     * @param Request $request
     * @return View
     */
    public function create(Request $request): View
    {
        $referer = $request->headers->get('referer');

        return view('admin.portfolio.recipe-step.create', compact('referer'));
    }

    /**
     * Store a newly created recipe step in storage.
     *
     * @param RecipeStepStoreRequest $request
     * @return RedirectResponse
     */
    public function store(RecipeStepStoreRequest $request): RedirectResponse
    {
        $recipeStep = RecipeStep::create($request->validated());

        $referer = $request->input('referer');

        if (!empty($referer)) {
            return redirect(str_replace(config('app.url'), '', $referer))
                ->with('success', 'Recipe step created successfully.');
        } else {
            return redirect()->route('admin.portfolio.recipe-step.index')
                ->with('success', 'Recipe step created successfully.');
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
        return view('admin.portfolio.recipe-step.show', compact('recipeStep'));
    }

    /**
     * Show the form for editing the specified recipe step.
     *
     * @param RecipeStep $recipeStep
     * @param Request $request
     * @return View
     */
    public function edit(RecipeStep $recipeStep): View
    {
        $referer = $request->headers->get('referer');

        return view('admin.portfolio.recipe-step.edit', compact('recipeStep', 'referer'));
    }

    /**
     * Update the specified recipe step in storage.
     *
     * @param RecipeStepUpdateRequest $request
     * @param RecipeStep $recipeStep
     * @return RedirectResponse
     */
    public function update(RecipeStepUpdateRequest $request, RecipeStep $recipeStep): RedirectResponse
    {
        $recipeStep->update($request->validated());

        $referer = $request->input('referer');

        if (!empty($referer)) {
            return redirect(str_replace(config('app.url'), '', $referer))
                ->with('success', 'Recipe step updated successfully.');
        } else {
            return redirect()->route('admin.portfolio.recipe-step.index')
                ->with('success', 'Recipe step updated successfully.');
        }
    }

    /**
     * Remove the specified recipe step from storage.
     *
     * @param RecipeStep $recipeStep
     * @param Request $request
     * @return RedirectResponse
     */
    public function destroy(RecipeStep $recipeStep, Request $request): RedirectResponse
    {
        $recipeStep->delete();

        $referer = $request->input('referer');

        if (!empty($referer)) {
            return redirect(str_replace(config('app.url'), '', $referer))
                ->with('success', 'Recipe step deleted successfully.');
        } else {
            return redirect()->route('admin.portfolio.recipe-step.index')
                ->with('success', 'Recipe step deleted successfully.');
        }
    }
}
