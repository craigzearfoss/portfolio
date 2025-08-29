<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Portfolio\Recipe;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RecipeController extends Controller
{
    protected $numPerPage = 20;

    /**
     * Display a listing of the art.
     */
    public function index(): View
    {
        $recipes = Recipe::where('public', 1)
            ->where('disabled', 0)
            ->orderBy('sequence', 'asc')
            ->paginate($this->numPerPage);

        $title = 'Recipes';
        return view('front.recipe.index', compact('recipes', 'title'))
            ->with('i', (request()->input('page', 1) - 1) * $this->numPerPage);
    }

    /**
     * Display the specified recipe.
     */
    public function show(Recipe $recipe): View
    {
        return view('front.recipe.show', compact('recipe'));
    }
}
