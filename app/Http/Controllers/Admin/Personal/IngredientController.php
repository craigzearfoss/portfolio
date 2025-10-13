<?php

namespace App\Http\Controllers\Admin\Personal;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Personal\StoreIngredientsRequest;
use App\Http\Requests\Personal\UpdateIngredientsRequest;
use App\Models\Personal\Ingredient;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 *
 */
class IngredientController extends BaseAdminController
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
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can add ingredients.');
        }

        return view('admin.personal.ingredient.create');
    }

    /**
     * Store a newly created ingredient in storage.
     *
     * @param StoreIngredientsRequest $storeIngredientsRequest
     * @return RedirectResponse
     */
    public function store(StoreIngredientsRequest $storeIngredientsRequest): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can add ingredients.');
        }

        $ingredient = Ingredient::create($storeIngredientsRequest->validated());

        return redirect(referer('admin.personal.ingredient.index'))
            ->with('success', $ingredient->name . ' added successfully.');
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
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can edit ingredients.');
        }

        return view('admin.personal.ingredient.edit', compact('ingredient'));
    }

    /**
     * Update the specified ingredient in storage.
     *
     * @param UpdateIngredientsRequest $updateIngredientsRequest
     * @param Ingredient $ingredient
     * @return RedirectResponse
     */
    public function update(UpdateIngredientsRequest $updateIngredientsRequest, Ingredient $ingredient): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can update ingredients.');
        }

        $ingredient->update($updateIngredientsRequest->validated());

        return redirect(referer('admin.personal.ingredient.index'))
            ->with('success', $ingredient->name . ' updated successfully.');
    }

    /**
     * Remove the specified ingredient from storage.
     *
     * @param Ingredient $ingredient
     * @return RedirectResponse
     */
    public function destroy(Ingredient $ingredient): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can delete ingredients.');
        }

        $ingredient->delete();

        return redirect(referer('admin.personal.ingredient.index'))
            ->with('success', $ingredient->name . ' deleted successfully.');
    }
}
