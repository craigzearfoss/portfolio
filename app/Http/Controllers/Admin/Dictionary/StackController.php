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
    protected $numPerPage = 20;

    /**
     * Display a listing of dictionary stacks.
     */
    public function index(): View
    {
        $dictionaryStacks = Stack::orderBy('name', 'asc')->paginate($this->numPerPage);

        return view('admin.dictionary.stack.index', compact('dictionaryStacks'))
            ->with('i', (request()->input('page', 1) - 1) * $this->numPerPage);
    }

    /**
     * Show the form for creating a new dictionary stack.
     */
    public function create(): View
    {
        return view('admin.dictionary.stack.create');
    }

    /**
     * Store a newly created dictionary stack in storage.
     */
    public function store(StackStoreRequest $request): RedirectResponse
    {
        $dictionaryStack =Stack::create($request->validated());

        return redirect()->route('admin.dictionary.stack.show', $dictionaryStack)
            ->with('success', 'Dictionary stack created successfully.');
    }

    /**
     * Display the specified dictionary stack.
     */
    public function show(Stack $dictionaryStack): View
    {
        return view('admin.dictionary.stack.show', compact('dictionaryStack'));
    }

    /**
     * Show the form for editing the specified dictionary stack.
     */
    public function edit(Stack $dictionaryStack): View
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can edit dictionary stack entries.');
        }

        return view('admin.dictionary.stack.edit', compact('dictionaryStack'));
    }

    /**
     * Update the specified dictionary stack in storage.
     */
    public function update(StackUpdateRequest $request,
                           Stack              $dictionaryStack): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can update dictionary stack entries.');
        }

        $dictionaryStack->update($request->validated());

        return redirect()->route('admin.dictionary.stack.show', $dictionaryStack)
            ->with('success', 'Dictionary stack updated successfully');
    }

    /**
     * Remove the specified dictionary stack from storage.
     */
    public function destroy(Stack $dictionaryStack): RedirectResponse
    {
        $dictionaryStack->delete();

        return redirect()->route('admin.dictionary.stack.index')
            ->with('success', 'Dictionary stack deleted successfully');
    }
}
