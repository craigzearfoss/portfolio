<?php

namespace App\Http\Controllers\Admin\Dictionary;

use App\Enums\PermissionEntityTypes;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Dictionary\StoreStacksRequest;
use App\Http\Requests\Dictionary\UpdateStacksRequest;
use App\Models\Dictionary\Category;
use App\Models\Dictionary\Stack;
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
class StackController extends BaseAdminController
{
    protected $PAGINATION_PER_PAGE = 30;

    /**
     * Display a listing of stacks.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        readGate(PermissionEntityTypes::RESOURCE, 'stack', $this->admin);

        $perPage = $request->query('per_page', $this->perPage());

        $stacks = Category::searchQuery($request->all())
            ->orderBy('name')
            ->paginate($perPage)->appends(request()->except('page'));

        return view('admin.dictionary.stack.index', compact('stacks'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new stack.
     *
     * @return View
     */
    public function create(): View
    {
        if (!isRootAdmin()) {
            abort(403, 'Only admins with root access can add stacks.');
        }

        return view('admin.dictionary.stack.create');
    }

    /**
     * Store a newly created stack in storage.
     *
     * @param StoreStacksRequest $request
     * @return RedirectResponse
     */
    public function store(StoreStacksRequest $request): RedirectResponse
    {
        if (!isRootAdmin()) {
            abort(403, 'Only admins with root access can add stacks.');
        }

        $stack = new Stack()->create($request->validated());

        return redirect()->route('admin.dictionary.stack.show', $stack)
            ->with('success', $stack->name . ' successfully added.');
    }

    /**
     * Display the specified stack.
     *
     * @param Stack $stack
     * @return View
     */
    public function show(Stack $stack): View
    {
        readGate(PermissionEntityTypes::RESOURCE, $stack, $this->admin);

        list($prev, $next) = Stack::prevAndNextPages($stack->id,
            'admin.dictionary.stack.show',
            null,
            ['full_name', 'asc']);

        return view('admin.dictionary.stack.show', compact('stack', 'prev', 'next'));
    }

    /**
     * Show the form for editing the specified stack.
     *
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        if (!isRootAdmin()) {
            abort(403, 'Only admins with root access can update stacks.');
        }

        $stack = new Stack()->findOrFail($id);

        return view('admin.dictionary.stack.edit', compact('stack'));
    }

    /**
     * Update the specified stack in storage.
     *
     * @param UpdateStacksRequest $request
     * @param Stack $stack
     * @return RedirectResponse
     */
    public function update(UpdateStacksRequest $request, Stack $stack): RedirectResponse
    {
        if (!isRootAdmin()) {
            abort(403, 'Only admins with root access can update stacks.');
        }

        $stack->update($request->validated());

        return redirect()->route('admin.dictionary.stack.show', $stack)
            ->with('success', $stack->name . ' successfully updated.');
    }

    /**
     * Remove the specified stack from storage.
     *
     * @param Stack $stack
     * @return RedirectResponse
     */
    public function destroy(Stack $stack): RedirectResponse
    {
        if (!isRootAdmin()) {
            abort(403, 'Only admins with root access can delete a stack.');
        }

        $stack->delete();

        return redirect(referer('admin.dictionary.index'))
            ->with('success', $stack->name . ' deleted successfully.');
    }
}
