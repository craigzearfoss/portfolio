<?php

namespace App\Http\Controllers\Admin\Dictionary;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dictionary\OperatingSystemStoreRequest;
use App\Http\Requests\Dictionary\OperatingSystemUpdateRequest;
use App\Models\Dictionary\OperatingSystem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class OperatingSystemController extends Controller
{
    const PER_PAGE = 20;

    /**
     * Display a listing of dictionary operating systems.
     */
    public function index(int $perPage = self::PER_PAGE): View
    {
        $dictionaryOperatingSystems = OperatingSystem::orderBy('name', 'asc')->paginate($perPage);

        return view('admin.dictionary.operating_system.index', compact('dictionaryOperatingSystems'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new dictionary operating system.
     */
    public function create(): View
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can add dictionary operating system entries.');
        }

        return view('admin.dictionary.operating_system.create');
    }

    /**
     * Store a newly created dictionary operating system in storage.
     */
    public function store(OperatingSystemStoreRequest $request): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can add dictionary operating system entries.');
        }

        OperatingSystem::create($request->validated());

        return redirect()->route('admin.dictionary.operating_system.index')
            ->with('success', 'Dictionary operating system created successfully.');
    }

    /**
     * Display the specified dictionary operating system.
     */
    public function show(OperatingSystem $dictionaryOperatingSystem): View
    {
        return view('admin.dictionary.operating_system.show', compact('dictionaryOperatingSystem'));
    }

    /**
     * Show the form for editing the specified dictionary operating system.
     */
    public function edit(OperatingSystem $dictionaryOperatingSystem): View
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can edit dictionary operating system entries.');
        }

        return view('admin.dictionary.operating_system.edit', compact('dictionaryOperatingSystem'));
    }

    /**
     * Update the specified dictionary operating system in storage.
     */
    public function update(OperatingSystemUpdateRequest $request,
                           OperatingSystem              $dictionaryOperatingSystem): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can update dictionary operating system entries.');
        }

        $dictionaryOperatingSystem->update($request->validated());

        return redirect()->route('admin.dictionary.operating_system.index')
            ->with('success', 'Dictionary operating system updated successfully');
    }

    /**
     * Remove the specified dictionary operating system from storage.
     */
    public function destroy(OperatingSystem $dictionaryOperatingSystem): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can delete dictionary operating system entries.');
        }

        $dictionaryOperatingSystem->delete();

        return redirect()->route('admin.dictionary.operating_system.index')
            ->with('success', 'Dictionary operating system deleted successfully');
    }
}
