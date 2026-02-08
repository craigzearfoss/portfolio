<?php

namespace App\Http\Controllers\Admin\Dictionary;

use App\Enums\PermissionEntityTypes;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Dictionary\StoreCategoriesRequest;
use App\Http\Requests\Dictionary\UpdateCategoriesRequest;
use App\Models\Dictionary\Category;
use App\Models\Personal\Unit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Illuminate\Support\Str;

/**
 *
 */
class CategoryController extends BaseAdminController
{
    protected $PAGINATION_PER_PAGE = 30;

    /**
     * Display a listing of categories.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        readGate(PermissionEntityTypes::RESOURCE, 'category', $this->admin);

        $perPage = $request->query('per_page', $this->perPage());

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
        if (!isRootAdmin()) {
            abort(403, 'Only admins with root access can add categories.');
        }

        return view('admin.dictionary.category.create');
    }

    /**
     * Store a newly created category in storage.
     *
     * @param StoreCategoriesRequest $request
     * @return RedirectResponse
     */
    public function store(StoreCategoriesRequest $request): RedirectResponse
    {
        if (!isRootAdmin()) {
            abort(403, 'Only admins with root access can add categories.');
        }

        $category = Category::create($request->validated());

        return redirect()->route('admin.dictionary.category.show', $category)
            ->with('success', $category->name . ' successfully added.');
    }

    /**
     * Display the specified category.
     *
     * @param Category $category
     * @return View
     */
    public function show(Category $category): View
    {
        readGate(PermissionEntityTypes::RESOURCE, $category, $this->admin);

        list($prev, $next) = Category::prevAndNextPages($category->id,
            'admin.dictionary.category.show',
            null,
            ['full_name', 'asc']);

        return view('admin.dictionary.category.show', compact('category', 'prev', 'next'));
    }

    /**
     * Show the form for editing the specified category.
     *
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $category = Category::findOrFail($id);

        updateGate(PermissionEntityTypes::RESOURCE, $category, $this->admin);

        return view('admin.dictionary.category.edit', compact('category'));
    }

    /**
     * Update the specified category in storage.
     *
     * @param UpdateCategoriesRequest $request
     * @param Category $category
     * @return RedirectResponse
     */
    public function update(UpdateCategoriesRequest $request, Category $category): RedirectResponse
    {
        Gate::authorize('update-resource', $category);

        $category->update($request->validated());

        return redirect()->route('admin.dictionary.category.show', $category)
            ->with('success', $category->name . ' successfully updated.');
    }

    /**
     * Remove the specified category from storage.
     *
     * @param Category $category
     * @return RedirectResponse
     */
    public function destroy(Category $category): RedirectResponse
    {
        deleteGate(PermissionEntityTypes::RESOURCE, $category, $this->admin);

        $category->delete();

        return redirect(referer('admin.dictionary.index'))
            ->with('success', $category->name . ' deleted successfully.');
    }
}
