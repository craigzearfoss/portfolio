<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CareerDictionaryStackStoreRequest;
use App\Http\Requests\CareerDictionaryStackUpdateRequest;
use App\Models\Career\DictionaryStack;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CareerDictionaryStackController extends Controller
{
    const NUM_PER_PAGE = 20;

    /**
     * Display a listing of dictionary stacks.
     */
    public function index(): View
    {
        $dictionaryStacks = DictionaryStack::orderBy('name', 'asc')->paginate(self::NUM_PER_PAGE);

        return view('admin.dictionary.stack.index', compact('dictionaryStacks'))
            ->with('i', (request()->input('page', 1) - 1) * self::NUM_PER_PAGE);
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
    public function store(CareerDictionaryStackStoreRequest $request): RedirectResponse
    {
        DictionaryStack::create($request->validated());

        return redirect()->route('admin.dictionary.stack.index')
            ->with('success', 'Dictionary stack created successfully.');
    }

    /**
     * Display the specified dictionary stack.
     */
    public function show(DictionaryStack $dictionaryStack): View
    {dd($dictionaryStack->databases()->pivot);
        return view('admin.dictionary.stack.show', compact('dictionaryStack'));
    }

    /**
     * Show the form for editing the specified dictionary stack.
     */
    public function edit(DictionaryStack $dictionaryStack): View
    {
        return view('admin.dictionary.stack.edit', compact('dictionaryStack'));
    }

    /**
     * Update the specified dictionary stack in storage.
     */
    public function update(CareerDictionaryStackUpdateRequest $request,
                           DictionaryStack $dictionaryStack): RedirectResponse
    {
        $dictionaryStack->update($request->validated());

        return redirect()->route('admin.dictionary.stack.index')
            ->with('success', 'Dictionary stack updated successfully');
    }

    /**
     * Remove the specified dictionary stack from storage.
     */
    public function destroy(DictionaryStack $dictionaryStack): RedirectResponse
    {
        $dictionaryStack->delete();

        return redirect()->route('admin.dictionary.stack.index')
            ->with('success', 'Dictionary stack deleted successfully');
    }
}
