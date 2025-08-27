<?php

namespace App\Http\Controllers\Admin\Dictionary;

use App\Http\Controllers\Controller;
use App\Http\Requests\CareerDictionaryCategoryStoreRequest;
use App\Http\Requests\CareerDictionaryCategoryUpdateRequest;
use App\Models\Career\DictionaryCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CategoryController extends Controller
{
    const NUM_PER_PAGE = 20;

    /**
     * Display a listing of dictionary categories.
     */
    public function index(): View
    {
        $dictionaryCategories = DictionaryCategory::orderBy('name', 'asc')->paginate(self::NUM_PER_PAGE);

        return view('admin.dictionary.category.index', compact('dictionaryCategories'))
            ->with('i', (request()->input('page', 1) - 1) * self::NUM_PER_PAGE);
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
    public function store(CareerDictionaryCategoryStoreRequest $request): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can add dictionary category entries.');
        }

        DictionaryCategory::create($request->validated());

        return redirect()->route('admin.dictionary.category.index')
            ->with('success', 'Dictionary category created successfully.');
    }

    /**
     * Display the specified dictionary category.
     */
    public function show(DictionaryCategory $dictionaryCategory): View
    {
        return view('admin.dictionary.category.show', compact('dictionaryCategory'));
    }

    /**
     * Show the form for editing the specified dictionary category.
     */
    public function edit(DictionaryCategory $dictionaryCategory): View
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can edit dictionary category entries.');
        }

        return view('admin.dictionary.category.edit', compact('dictionaryCategory'));
    }

    /**
     * Update the specified dictionary category in storage.
     */
    public function update(CareerDictionaryCategoryUpdateRequest $request,
                           DictionaryCategory $dictionaryCategory): RedirectResponse
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
    public function destroy(DictionaryCategory $dictionaryCategory): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can delete dictionary category entries.');
        }

        $dictionaryCategory->delete();

        return redirect()->route('admin.dictionary.category.index')
            ->with('success', 'Dictionary category deleted successfully');
    }
}
