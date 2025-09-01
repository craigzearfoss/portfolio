<?php

namespace App\Http\Controllers\Admin\Dictionary;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dictionary\StackStoreRequest;
use App\Http\Requests\Dictionary\StackUpdateRequest;
use App\Models\Dictionary\Stack;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class StackController extends Controller
{
    const PER_PAGE = 20;

    /**
     * Display a listing of stacks.
     */
    public function index(int $perPage = self::PER_PAGE): View
    {
        $stacks = Stack::orderBy('name', 'asc')->paginate($perPage);

        return view('admin.dictionary.stack.index', compact('stacks'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new stack.
     */
    public function create(): View
    {
        return view('admin.dictionary.stack.create');
    }

    /**
     * Store a newly created stack in storage.
     */
    public function store(StackStoreRequest $request): RedirectResponse
    {
        $stack =Stack::create($request->validated());

        return redirect()->route('admin.dictionary.stack.show', $stack)
            ->with('success', 'Stack created successfully.');
    }

    /**
     * Display the specified stack.
     */
    public function show(Stack $stack): View
    {
        return view('admin.dictionary.stack.show', compact('stack'));
    }

    /**
     * Show the form for editing the specified stack.
     */
    public function edit(Stack $stack): View
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can edit stack entries.');
        }

        return view('admin.dictionary.stack.edit', compact('stack'));
    }

    /**
     * Update the specified stack in storage.
     */
    public function update(StackUpdateRequest $request,
                           Stack              $stack): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can update stack entries.');
        }

        $stack->update($request->validated());

        return redirect()->route('admin.dictionary.stack.show', $stack)
            ->with('success', 'Stack updated successfully');
    }

    /**
     * Remove the specified stack from storage.
     */
    public function destroy(Stack $stack): RedirectResponse
    {
        $stack->delete();

        return redirect()->route('admin.dictionary.stack.index')
            ->with('success', 'Stack deleted successfully');
    }
}
