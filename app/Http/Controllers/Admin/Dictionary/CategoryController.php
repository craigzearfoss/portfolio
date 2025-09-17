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
        $perPage= $request->query('per_page', $this->perPage);

        $categories = Category::orderBy('name', 'asc')->paginate($perPage);

        return view('admin.dictionary.category.index', compact('categories'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new category.
     *
     * @param Request $request
     * @return View
     */
    public function create(Request $request): View
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can add category entries.');
        }

        $referer = Request()->headers->get('referer');

        return view('admin.dictionary.category.create', compact('referer'));
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
            abort(403, 'Only admins with root access can add category entries.');
        }

        $category = Category::create($request->validated());

        $referer = $request->input('referer');

        if (!empty($referer)) {
            return redirect(str_replace(config('app.url'), '', $referer))
                ->with('success', $category->name . ' created successfully.');
        } else {
            return redirect()->route('admin.dictionary.category.index')
                ->with('success', $category-> name . ' created successfully.');
        }
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
     * @param Request $request
     * @return View
     */
    public function edit(Category $category, Request $request): View
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can edit category entries.');
        }

        $referer = $request->headers->get('referer');

        return view('admin.dictionary.category.edit', compact('category', 'referer'));
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
            abort(403, 'Only admins with root access can update category entries.');
        }

        // Validate the posted data and generated slug.
        $validatedData = $request->validated();
        $request->merge([ 'slug' => Str::slug($validatedData['name']) ]);
        $request->validate(['slug' => [ Rule::unique('posts', 'slug') ] ]);
        $category->update($request->validated());

        $referer = $request->input('referer');

        if (!empty($referer)) {
            return redirect(str_replace(config('app.url'), '', $referer))
                ->with('success', $category->name . ' updated successfully.');
        } else {
            return redirect()->route('admin.dictionary.category.index')
                ->with('success', $category->name . ' updated successfully');
        }
    }

    /**
     * Remove the specified category from storage.
     *
     * @param Category $category
     * @param Request $request
     * @return RedirectResponse
     */
    public function destroy(Category $category, Request $request): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can delete category entries.');
        }

        $category->delete();

        $referer = $request->input('referer');

        if (!empty($referer)) {
            return redirect(str_replace(config('app.url'), '', $referer))
                ->with('success', $category->name . ' deleted successfully.');
        } else {
            return redirect()->route('admin.dictionary.category.index')
                ->with('success', $category->name . ' deleted successfully');
        }
    }
}
