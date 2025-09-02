<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Http\Controllers\Controller;
use App\Http\Requests\Portfolio\RecipeStepStoreRequest;
use App\Http\Requests\Portfolio\RecipeStepUpdateRequest;
use App\Models\Portfolio\RecipeStep;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RecipeStepController extends Controller
{
    /**
     * Display a listing of recipe steps.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $perPage= $request->query('per_page', $this->perPage);

        $recipeSteps = RecipeStep::latest()->paginate($perPage);

        return view('admin.portfolio.recipe-step.index', compact('recipeSteps'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new recipe step.
     */
    public function create(): View
    {
        return view('admin.portfolio.recipe-step.create');
    }

    /**
     * Store a newly created recipe step in storage.
     */
    public function store(RecipeStepStoreRequest $request): RedirectResponse
    {
        RecipeStep::create($request->validated());

        return redirect()->route('admin.portfolio.recipe-step.index')
            ->with('success', 'Recipe step created successfully.');
    }

    /**
     * Display the specified recipe step.
     */
    public function show(RecipeStep $recipeStep): View
    {
        return view('admin.portfolio.recipe-step.show', compact('recipeStep'));
    }

    /**
     * Show the form for editing the specified recipe step.
     */
    public function edit(RecipeStep $recipeStep): View
    {
        return view('admin.portfolio.recipe-step.edit', compact('recipeStep'));
    }

    /**
     * Update the specified recipe step in storage.
     */
    public function update(RecipeStepUpdateRequest $request, RecipeStep $recipeStep): RedirectResponse
    {
        $recipeStep->update($request->validated());

        return redirect()->route('admin.portfolio.recipe-step.index')
            ->with('success', 'Recipe step updated successfully');
    }

    /**
     * Remove the specified recipe step from storage.
     */
    public function destroy(RecipeStep $recipeStep): RedirectResponse
    {
        $recipeStep->delete();

        return redirect()->route('admin.portfolio.recipe-step.index')
            ->with('success', 'Recipe step deleted successfully');
    }
}
