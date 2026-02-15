<?php

namespace App\Http\Controllers\Guest\Dictionary;

use App\Http\Controllers\Guest\BaseGuestController;
use App\Models\Dictionary\Category;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 *
 */
class CategoryController extends BaseGuestController
{
    /**
     * Display a listing of categories.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $perPage = $request->query('per_page', $this->perPage());

        $categories = Category::where('name', '!=', 'other')
            ->where('public', true)
            ->where('disabled', false)
            ->where('name', '!=', 'other')
            ->orderBy('name')
            ->paginate($perPage)->appends(request()->except('page'));

        return view(themedTemplate('guest.dictionary.category.index'), compact('categories'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Display the specified category.
     *
     * @param string $slug
     * @return View
     */
    public function show(string $slug): View
    {
        if (!$category = Category::where('slug', $slug)->first()) {
            throw new ModelNotFoundException();
        }

        return view(themedTemplate('guest.dictionary.category.show'), compact('category'));
    }
}
