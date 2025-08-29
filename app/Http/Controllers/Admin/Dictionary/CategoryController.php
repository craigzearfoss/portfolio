<?php

namespace App\Http\Controllers\Admin\Dictionary;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dictionary\CategoryStoreRequest;
use App\Http\Requests\Dictionary\CategoryUpdateRequest;
use App\Models\Dictionary\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CategoryController extends Controller
{
    const PER_PAGE = 20;

    /**
     * Display a listing of dictionary categories.
     */
    public function index(int $perPage = self::PER_PAGE): View
    {
        $dictionaryCategories = Category::orderBy('name', 'asc')->paginate($perPage);

        return view('admin.dictionary.category.index', compact('dictionaryCategories'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new dictionary category.
     */
    public function create(): View
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can add dictionary category entries.');
        }

        return view('admin.dictionary.category.create');
    }

    /**
     * Store a newly created dictionary category in storage.
     */
    public function store(CategoryStoreRequest $request): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can add dictionary category entries.');
        }

        Category::create($request->validated());

        return redirect()->route('admin.dictionary.category.index')
            ->with('success', 'Dictionary category created successfully.');
    }

    /**
     * Display the specified dictionary category.
     */
    public function show(Category $dictionaryCategory): View
    {
        return view('admin.dictionary.category.show', compact('dictionaryCategory'));
    }

    /**
     * Show the form for editing the specified dictionary category.
     */
    public function edit(Category $dictionaryCategory): View
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can edit dictionary category entries.');
        }

        return view('admin.dictionary.category.edit', compact('dictionaryCategory'));
    }

    /**
     * Update the specified dictionary category in storage.
     */
    public function update(CategoryUpdateRequest $request,
                           Category              $dictionaryCategory): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can update dictionary category entries.');
        }

        $dictionaryCategory->update($request->validated());

        return redirect()->route('admin.dictionary.category.index')
            ->with('success', 'Dictionary category updated successfully');
    }

    /**
     * Remove the specified dictionary category from storage.
     */
    public function destroy(Category $dictionaryCategory): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can delete dictionary category entries.');
        }

        $dictionaryCategory->delete();

        return redirect()->route('admin.dictionary.category.index')
            ->with('success', 'Dictionary category deleted successfully');
    }
}
