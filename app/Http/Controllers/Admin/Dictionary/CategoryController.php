<?php

namespace App\Http\Controllers\Admin\Dictionary;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dictionary\CategoryStoreRequest;
use App\Http\Requests\Dictionary\CategoryUpdateRequest;
use App\Models\Dictionary\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CategoryController extends Controller
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

        $categories = Category::orderBy('name', 'asc')->paginate($perPage);

        return view('admin.dictionary.category.index', compact('categories'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new category.
     */
    public function create(): View
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can add category entries.');
        }

        return view('admin.dictionary.category.create');
    }

    /**
     * Store a newly created category in storage.
     */
    public function store(CategoryStoreRequest $request): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can add category entries.');
        }

        Category::create($request->validated());

        return redirect()->route('admin.dictionary.category.index')
            ->with('success', 'category created successfully.');
    }

    /**
     * Display the specified category.
     */
    public function show(Category $category): View
    {
        return view('admin.dictionary.category.show', compact('category'));
    }

    /**
     * Show the form for editing the specified category.
     */
    public function edit(Category $category): View
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can edit category entries.');
        }

        return view('admin.dictionary.category.edit', compact('category'));
    }

    /**
     * Update the specified category in storage.
     */
    public function update(CategoryUpdateRequest $request,
                           Category              $category): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can update category entries.');
        }

        $category->update($request->validated());

        return redirect()->route('admin.dictionary.category.index')
            ->with('success', 'category updated successfully');
    }

    /**
     * Remove the specified category from storage.
     */
    public function destroy(Category $category): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can delete category entries.');
        }

        $category->delete();

        return redirect()->route('admin.dictionary.category.index')
            ->with('success', 'category deleted successfully');
    }
}
