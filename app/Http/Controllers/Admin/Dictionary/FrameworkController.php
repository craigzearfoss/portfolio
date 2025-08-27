<?php

namespace App\Http\Controllers\Admin\Dictionary;

use App\Http\Controllers\Controller;
use App\Http\Requests\CareerDictionaryFrameworkStoreRequest;
use App\Http\Requests\CareerDictionaryFrameworkUpdateRequest;
use App\Models\Career\DictionaryFramework;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class FrameworkController extends Controller
{
    const NUM_PER_PAGE = 20;

    /**
     * Display a listing of dictionary frameworks.
     */
    public function index(): View
    {
        $dictionaryFrameworks = DictionaryFramework::orderBy('name', 'asc')->paginate(self::NUM_PER_PAGE);

        return view('admin.dictionary.framework.index', compact('dictionaryFrameworks'))
            ->with('i', (request()->input('page', 1) - 1) * self::NUM_PER_PAGE);
    }

    /**
     * Show the form for creating a new dictionary framework.
     */
    public function create(): View
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can add dictionary framework entries.');
        }

        return view('admin.dictionary.framework.create');
    }

    /**
     * Store a newly created dictionary framework in storage.
     */
    public function store(CareerDictionaryFrameworkStoreRequest $request): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can add dictionary framework entries.');
        }

        DictionaryFramework::create($request->validated());

        return redirect()->route('admin.dictionary.framework.index')
            ->with('success', 'Dictionary framework created successfully.');
    }

    /**
     * Display the specified dictionary framework.
     */
    public function show(DictionaryFramework $dictionaryFramework): View
    {
        return view('admin.dictionary.framework.show', compact('dictionaryFramework'));
    }

    /**
     * Show the form for editing the specified dictionary framework.
     */
    public function edit(DictionaryFramework $dictionaryFramework): View
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can edit dictionary framework entries.');
        }

        return view('admin.dictionary.framework.edit', compact('dictionaryFramework'));
    }

    /**
     * Update the specified dictionary framework in storage.
     */
    public function update(CareerDictionaryFrameworkUpdateRequest $request,
                           DictionaryFramework $dictionaryFramework): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can update dictionary framework entries.');
        }

        $dictionaryFramework->update($request->validated());

        return redirect()->route('admin.dictionary.framework.index')
            ->with('success', 'Dictionary framework updated successfully');
    }

    /**
     * Remove the specified dictionary framework from storage.
     */
    public function destroy(DictionaryFramework $dictionaryFramework): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can delete dictionary framework entries.');
        }

        $dictionaryFramework->delete();

        return redirect()->route('admin.dictionary.framework.index')
            ->with('success', 'Dictionary framework deleted successfully');
    }
}
