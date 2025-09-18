<?php

namespace App\Http\Controllers\Admin\Dictionary;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Dictionary\CategoryStoreRequest;
use App\Http\Requests\Dictionary\CategoryUpdateRequest;
use App\Models\Dictionary\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Illuminate\Support\Str;

/**
 *
 */
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
        $perPage = $request->query('per_page', $this->perPage);

        $categories = Category::orderBy('name', 'asc')->paginate($perPage);

        return view('admin.dictionary.category.index', compact('categories'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new category.
     *
     * @return View
     */
    public function create(): View
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can add categories.');
        }

        return view('admin.dictionary.category.create');
    }

    /**
     * Store a newly created category in storage.
     *
     * @param CategoryStoreRequest $request
     * @return RedirectResponse
     */
    public function store(CategoryStoreRequest $request): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can add categories.');
        }

        $category = Category::create($request->validated());

        return redirect(referer('admin.dictionary.index'))
            ->with('success', $category->name . ' created successfully.');
    }

    /**
     * Display the specified category.
     *
     * @param Category $category
     * @return View
     */
    public function show(Category $category): View
    {
        return view('admin.dictionary.category.show', compact('category'));
    }

    /**
     * Show the form for editing the specified category.
     *
     * @param Category $category
     * @return View
     */
    public function edit(Category $category): View
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can edit categories.');
        }

        return view('admin.dictionary.category.edit', compact('category'));
    }

    /**
     * Update the specified category in storage.
     *
     * @param CategoryUpdateRequest $request
     * @param Category $category
     * @return RedirectResponse
     */
    public function update(CategoryUpdateRequest $request, Category $category): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can update categories.');
        }

        $category->update($request->validated());

        return redirect(referer('admin.dictionary.index'))
            ->with('success', $category->name . ' updated successfully.');
    }

    /**
     * Remove the specified category from storage.
     *
     * @param Category $category
     * @return RedirectResponse
     */
    public function destroy(Category $category): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can delete categories.');
        }

        $category->delete();

        return redirect(referer('admin.dictionary.index'))
            ->with('success', $category->name . ' deleted successfully.');
    }
}
