<?php

namespace App\Http\Controllers\Front\Dictionary;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Dictionary\CategoryStoreRequest;
use App\Http\Requests\Dictionary\CategoryUpdateRequest;
use App\Models\Dictionary\Category;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CategoryController extends BaseController
{
    /**
     * Display a listing of categories.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $perPage= $request->query('per_page', $this->perPage);

        $categories = Category::where('disabled', 0)
            ->where('public', 1)
            ->where('name', '!=', 'other')
            ->orderBy('name', 'asc')
            ->paginate($perPage);

        return view('front.dictionary.category.index', compact('categories'))
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

        return view('front.dictionary.category.show', compact('category'));
    }
}
