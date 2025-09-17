<?php

namespace App\Http\Controllers\Admin\Dictionary;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Dictionary\StackStoreRequest;
use App\Http\Requests\Dictionary\StackUpdateRequest;
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
class StackController extends BaseController
{
    /**
     * Display a listing of stacks.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $perPage= $request->query('per_page', $this->perPage);

        $stacks = Stack::orderBy('name', 'asc')->paginate($perPage);

        return view('admin.dictionary.stack.index', compact('stacks'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new stack.
     *
     * @param Request $request
     * @return View
     */
    public function create(Request $request): View
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can add stacks.');
        }

        $referer = $request->headers->get('referer');

        return view('admin.dictionary.stack.create', compact('referer'));
    }

    /**
     * Store a newly created stack in storage.
     *
     * @param StackStoreRequest $request
     * @return RedirectResponse
     */
    public function store(StackStoreRequest $request): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can add stacks.');
        }

        $stack = Stack::create($request->validated());

        $referer = $request->input('referer');

        if (!empty($referer)) {
            return redirect(str_replace(config('app.url'), '', $referer))
                ->with('success', $stack->name . ' created successfully.');
        } else {
            return redirect()->route('admin.dictionary.stack.show', $stack)
                ->with('success', $stack->name . ' created successfully.');
        }
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
     * @param Request $request
     * @return View
     */
    public function edit(Stack $stack, Request $request): View
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can edit stacks.');
        }

        $referer = $request->headers->get('referer');

        return view('admin.dictionary.stack.edit', compact('stack', 'referer'));
    }

    /**
     * Update the specified stack in storage.
     *
     * @param StackUpdateRequest $request
     * @param Stack $stack
     * @return RedirectResponse
     */
    public function update(StackUpdateRequest $request, Stack $stack): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can update stacks.');
        }

        // Validate the posted data and generated slug.
        $validatedData = $request->validated();
        $request->merge([ 'slug' => Str::slug($validatedData['name']) ]);
        $request->validate(['slug' => [ Rule::unique('posts', 'slug') ] ]);
        $stack->update($request->validated());

        $referer = $request->input('referer');

        if (!empty($referer)) {
            return redirect(str_replace(config('app.url'), '', $referer))
                ->with('success', $stack->name . ' updated successfully.');
        } else {
            return redirect()->route('admin.dictionary.stack.show', $stack)
                ->with('success', $stack->name . ' updated successfully');
        }
    }

    /**
     * Remove the specified stack from storage.
     *
     * @param Stack $stack
     * @param Request $request
     * @return RedirectResponse
     */
    public function destroy(Stack $stack, Request $request): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can delete stacks.');
        }

        $stack->delete();

        $referer = $request->input('referer');

        if (!empty($referer)) {
            return redirect(str_replace(config('app.url'), '', $referer))
                ->with('success', $stack->name . ' deleted successfully.');
        } else {
            return redirect()->route('admin.dictionary.stack.index')
                ->with('success', $stack->name . ' deleted successfully');
        }
    }
}
