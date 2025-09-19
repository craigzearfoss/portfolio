<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Portfolio\IngredientStoreRequest;
use App\Http\Requests\Portfolio\IngredientUpdateRequest;
use App\Models\Portfolio\Ingredient;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Illuminate\Support\Str;

/**
 *
 */
class IngredientController extends BaseController
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

        return view('admin.portfolio.ingredient.index', compact('ingredients'))
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

        return view('admin.portfolio.ingredient.create');
    }

    /**
     * Store a newly created ingredient in storage.
     *
     * @param IngredientStoreRequest $request
     * @return RedirectResponse
     */
    public function store(IngredientStoreRequest $request): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can add ingredients.');
        }

        $ingredient = Ingredient::create($request->validated());

        return redirect(referer('admin.portfolio.ingredient.index'))
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
        return view('admin.portfolio.ingredient.show', compact('ingredient'));
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

        return view('admin.portfolio.ingredient.edit', compact('ingredient'));
    }

    /**
     * Update the specified ingredient in storage.
     *
     * @param IngredientUpdateRequest $request
     * @param Ingredient $ingredient
     * @return RedirectResponse
     */
    public function update(IngredientUpdateRequest $request, Ingredient $ingredient): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can update ingredients.');
        }

        $ingredient->update($request->validated());

        return redirect(referer('admin.portfolio.ingredient.index'))
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

        return redirect(referer('admin.portfolio.ingredient.index'))
            ->with('success', $ingredient->name . ' deleted successfully.');
    }
}
