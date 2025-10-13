<?php

namespace App\Http\Controllers\Admin\Dictionary;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Dictionary\StoreStacksRequest;
use App\Http\Requests\Dictionary\UpdateStacksRequest;
use App\Models\Dictionary\Stack;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Illuminate\Support\Str;

/**
 *
 */
class StackController extends BaseAdminController
{
    /**
     * Display a listing of stacks.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $perPage = $request->query('per_page', $this->perPage);

        $stacks = Stack::orderBy('name', 'asc')->paginate($perPage);

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
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can add stacks.');
        }

        return view('admin.dictionary.stack.create');
    }

    /**
     * Store a newly created stack in storage.
     *
     * @param StoreStacksRequest $storeStacksRequest
     * @return RedirectResponse
     */
    public function store(StoreStacksRequest $storeStacksRequest): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can add stacks.');
        }

        $stack = Stack::create($storeStacksRequest->validated());

        return redirect(referer('admin.dictionary.index'))
            ->with('success', $stack->name . ' added successfully.');
    }

    /**
     * Display the specified stack.
     *
     * @param Stack $stack
     * @return View
     */
    public function show(Stack $stack): View
    {
        return view('admin.dictionary.stack.show', compact('stack'));
    }

    /**
     * Show the form for editing the specified stack.
     *
     * @param Stack $stack
     * @return View
     */
    public function edit(Stack $stack): View
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can edit stacks.');
        }

        return view('admin.dictionary.stack.edit', compact('stack'));
    }

    /**
     * Update the specified stack in storage.
     *
     * @param UpdateStacksRequest $updateStacksRequest
     * @param Stack $stack
     * @return RedirectResponse
     */
    public function update(UpdateStacksRequest $updateStacksRequest, Stack $stack): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can update stacks.');
        }

        $stack->update($updateStacksRequest->validated());

        return redirect(referer('admin.dictionary.index'))
            ->with('success', $stack->name . ' updated successfully.');
    }

    /**
     * Remove the specified stack from storage.
     *
     * @param Stack $stack
     * @return RedirectResponse
     */
    public function destroy(Stack $stack): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can delete stacks.');
        }

        $stack->delete();

        return redirect(referer('admin.dictionary.index'))
            ->with('success', $stack->name . ' deleted successfully.');
    }
}
