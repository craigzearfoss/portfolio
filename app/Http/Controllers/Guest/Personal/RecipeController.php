<?php

namespace App\Http\Controllers\Guest\Personal;

use App\Http\Controllers\Guest\BaseGuestController;
use App\Models\Personal\Recipe;
use App\Models\System\Admin;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 *
 */
class RecipeController extends BaseGuestController
{
    /**
     * Display a listing of recipes.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $perPage = $request->query('per_page', $this->perPage());

        $recipes = new Recipe()->searchQuery(request()->except('id'), $this->owner ?? null)
            ->orderBy('name')
            ->paginate($perPage)->appends(request()->except('page'));

        return view(themedTemplate('guest.personal.recipe.index'), compact('recipes'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Display the specified recipe.
     *
     * @param Admin $admin
     * @param string $slug
     * @return View
     */
    public function show(Admin $admin, string $slug): View
    {
        if (!$recipe = new Recipe()->where('owner_id', '=', $admin['id'])
            ->where('slug', '=', $slug)->first()
        ) {
            throw new ModelNotFoundException();
        }

        return view(themedTemplate('guest.personal.recipe.show'), compact('recipe'));
    }
}
