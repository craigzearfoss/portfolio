<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Http\Controllers\Controller;
use App\Http\Requests\Portfolio\IngredientStoreRequest;
use App\Http\Requests\Portfolio\IngredientUpdateRequest;
use App\Models\Portfolio\Ingredient;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class IngredientController extends Controller
{
    /**
     * Display a listing of ingredients.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $perPage= $request->query('per_page', $this->perPage);

        $ingredients = Ingredient::orderBy('name', 'asc')->paginate($perPage);

        return view('admin.portfolio.ingredient.index', compact('ingredients'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new ingredient.
     */
    public function create(): View
    {
        return view('admin.portfolio.ingredient.create');
    }

    /**
     * Store a newly created ingredient in storage.
     */
    public function store(IngredientStoreRequest $request): RedirectResponse
    {
        Ingredient::create($request->validated());

        return redirect()->route('admin.portfolio.ingredient.index')
            ->with('success', 'Ingredient created successfully.');
    }

    /**
     * Display the specified ingredient.
     */
    public function show(Ingredient $ingredient): View
    {
        return view('admin.portfolio.ingredient.show', compact('ingredient'));
    }

    /**
     * Show the form for editing the specified ingredient.
     */
    public function edit(Ingredient $ingredient): View
    {
        return view('admin.portfolio.ingredient.edit', compact('ingredient'));
    }

    /**
     * Update the specified ingredient in storage.
     */
    public function update(IngredientUpdateRequest $request, Ingredient $ingredient): RedirectResponse
    {
        $ingredient->update($request->validated());

        return redirect()->route('admin.portfolio.ingredient.index')
            ->with('success', 'Ingredient updated successfully');
    }

    /**
     * Remove the specified ingredient from storage.
     */
    public function destroy(Ingredient $ingredient): RedirectResponse
    {
        $ingredient->delete();

        return redirect()->route('admin.portfolio.ingredient.index')
            ->with('success', 'Ingredient deleted successfully');
    }
}
