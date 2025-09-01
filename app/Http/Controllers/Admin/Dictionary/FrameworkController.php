<?php

namespace App\Http\Controllers\Admin\Dictionary;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dictionary\FrameworkStoreRequest;
use App\Http\Requests\Dictionary\FrameworkUpdateRequest;
use App\Models\Dictionary\Framework;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class FrameworkController extends Controller
{
    const PER_PAGE = 20;

    /**
     * Display a listing of frameworks.
     */
    public function index(int $perPage = self::PER_PAGE): View
    {
        $frameworks = Framework::orderBy('name', 'asc')->paginate($perPage);

        return view('admin.dictionary.framework.index', compact('frameworks'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new framework.
     */
    public function create(): View
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can add framework entries.');
        }

        return view('admin.dictionary.framework.create');
    }

    /**
     * Store a newly created framework in storage.
     */
    public function store(FrameworkStoreRequest $request): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can add framework entries.');
        }

        Framework::create($request->validated());

        return redirect()->route('admin.dictionary.framework.index')
            ->with('success', 'Framework created successfully.');
    }

    /**
     * Display the specified framework.
     */
    public function show(Framework $framework): View
    {
        return view('admin.dictionary.framework.show', compact('framework'));
    }

    /**
     * Show the form for editing the specified framework.
     */
    public function edit(Framework $framework): View
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can edit framework entries.');
        }

        return view('admin.dictionary.framework.edit', compact('framework'));
    }

    /**
     * Update the specified framework in storage.
     */
    public function update(FrameworkUpdateRequest $request,
                           Framework              $framework): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can update framework entries.');
        }

        $framework->update($request->validated());

        return redirect()->route('admin.dictionary.framework.index')
            ->with('success', 'Framework updated successfully');
    }

    /**
     * Remove the specified framework from storage.
     */
    public function destroy(Framework $framework): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can delete framework entries.');
        }

        $framework->delete();

        return redirect()->route('admin.dictionary.framework.index')
            ->with('success', 'Framework deleted successfully');
    }
}
