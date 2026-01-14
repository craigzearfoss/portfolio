<?php

namespace App\Http\Controllers\Admin\Root\Personal;

use App\Http\Controllers\Admin\Root\BaseAdminRootController;
use App\Http\Requests\Personal\StoreIngredientsRequest;
use App\Http\Requests\Personal\UpdateIngredientsRequest;
use App\Models\Personal\Ingredient;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

/**
 *
 */
class IngredientController extends BaseAdminRootController
{
    /**
     * Display a listing of ingredients.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $perPage = $request->query('per_page', $this->perPage);

        $ingredients = Ingredient::orderBy('name', 'asc')->paginate($perPage);

        return view('admin.personal.ingredient.index', compact('ingredients'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new ingredient.
     *
     * @return View
     */
    public function create(): View
    {
        if (!isRootAdmin()) {
            abort(403, 'Only admins with root access can add ingredients.');
        }

        return view('admin.personal.ingredient.create');
    }

    /**
     * Store a newly created ingredient in storage.
     *
     * @param StoreIngredientsRequest $request
     * @return RedirectResponse
     */
    public function store(StoreIngredientsRequest $request): RedirectResponse
    {
        if (!isRootAdmin()) {
            abort(403, 'Only admins with root access can add ingredients.');
        }

        $ingredient = Ingredient::create($request->validated());

        return redirect()->route('admin.personal.ingredient.show', $ingredient)
            ->with('success', $ingredient->name . ' successfully added.');
    }

    /**
     * Display the specified ingredient.
     *
     * @param Ingredient $ingredient
     * @return View
     */
    public function show(Ingredient $ingredient): View
    {
        return view('admin.personal.ingredient.show', compact('ingredient'));
    }

    /**
     * Show the form for editing the specified ingredient.
     *
     * @param Ingredient $ingredient
     * @return View
     */
    public function edit(Ingredient $ingredient): View
    {
        Gate::authorize('update-resource', $ingredient);

        return view('admin.personal.ingredient.edit', compact('ingredient'));
    }

    /**
     * Update the specified ingredient in storage.
     *
     * @param UpdateIngredientsRequest $request
     * @param Ingredient $ingredient
     * @return RedirectResponse
     */
    public function update(UpdateIngredientsRequest $request, Ingredient $ingredient): RedirectResponse
    {
        Gate::authorize('update-resource', $ingredient);

        $ingredient->update($request->validated());

        return redirect()->route('admin.personal.ingredient.show', $ingredient)
            ->with('success', $ingredient->name . ' successfully updated.');
    }

    /**
     * Remove the specified ingredient from storage.
     *
     * @param Ingredient $ingredient
     * @return RedirectResponse
     */
    public function destroy(Ingredient $ingredient): RedirectResponse
    {
        Gate::authorize('delete-resource', $ingredient);

        $ingredient->delete();

        return redirect(referer('admin.personal.ingredient.index'))
            ->with('success', $ingredient->name . ' deleted successfully.');
    }
}
