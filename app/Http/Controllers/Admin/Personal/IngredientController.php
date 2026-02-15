<?php

namespace App\Http\Controllers\Admin\Personal;

use App\Enums\PermissionEntityTypes;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Personal\StoreIngredientsRequest;
use App\Http\Requests\Personal\UpdateIngredientsRequest;
use App\Models\Personal\Ingredient;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rules\In;
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
        readGate(PermissionEntityTypes::RESOURCE, 'ingredient', $this->admin);

        $perPage = $request->query('per_page', $this->perPage());

        $ingredients = Ingredient::where('name', '!=', 'other')
            ->orderBy('name')
            ->paginate($perPage)->appends(request()->except('page'));

        $pageTitle = 'Ingredients';

        return view('admin.personal.ingredient.index', compact('ingredients', 'pageTitle'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new ingredient.
     *
     * @return View
     */
    public function create(): View
    {
        createGate(PermissionEntityTypes::RESOURCE, 'ingredient', $this->admin);

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
        createGate(PermissionEntityTypes::RESOURCE, 'ingredient', $this->admin);

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
        readGate(PermissionEntityTypes::RESOURCE, $ingredient, $this->admin);

        list($prev, $next) = Ingredient::prevAndNextPages($ingredient->id,
            'admin.personal.ingredient.show',
            $this->owner->id ?? null,
            ['name', 'asc']);

        return view('admin.personal.ingredient.show', compact('ingredient', 'prev', 'next'));
    }

    /**
     * Show the form for editing the specified ingredient.
     *
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $ingredient = Ingredient::findOrFail($id);

        updateGate(PermissionEntityTypes::RESOURCE, $ingredient, $this->admin);

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
        $ingredient->update($request->validated());

        updateGate(PermissionEntityTypes::RESOURCE, $ingredient, $this->admin);

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
        deleteGate(PermissionEntityTypes::RESOURCE, $ingredient, $this->admin);

        $ingredient->delete();

        return redirect(referer('admin.personal.ingredient.index'))
            ->with('success', $ingredient->name . ' deleted successfully.');
    }
}
