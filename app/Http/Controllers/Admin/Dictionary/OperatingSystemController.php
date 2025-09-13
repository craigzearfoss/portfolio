<?php

namespace App\Http\Controllers\Admin\Dictionary;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Dictionary\OperatingSystemStoreRequest;
use App\Http\Requests\Dictionary\OperatingSystemUpdateRequest;
use App\Models\Dictionary\OperatingSystem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class OperatingSystemController extends BaseController
{
    /**
     * Display a listing of operations systems.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $perPage= $request->query('per_page', $this->perPage);

        $operatingSystems = OperatingSystemorderBy('name', 'asc')
            ->paginate($perPage);

        return view('admin.dictionary.operating-system.index', compact('operatingSystems'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new operating system.
     */
    public function create(): View
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can add operating system entries.');
        }

        return view('admin.dictionary.operating-system.create');
    }

    /**
     * Store a newly created operating system in storage.
     */
    public function store(OperatingSystemStoreRequest $request): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can add operating system entries.');
        }

        OperatingSystem::create($request->validated());

        return redirect()->route('admin.dictionary.operating-system.index')
            ->with('success', 'Operating system created successfully.');
    }

    /**
     * Display the specified operating system.
     */
    public function show(OperatingSystem $operatingSystem): View
    {
        return view('admin.dictionary.operating-system.show', compact('operatingSystem'));
    }

    /**
     * Show the form for editing the specified operating system.
     */
    public function edit(OperatingSystem $operatingSystem): View
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can edit operating system entries.');
        }

        return view('admin.dictionary.operating-system.edit', compact('operatingSystem'));
    }

    /**
     * Update the specified operating system in storage.
     */
    public function update(OperatingSystemUpdateRequest $request,
                           OperatingSystem              $operatingSystem): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can update operating system entries.');
        }

        $operatingSystem->update($request->validated());

        return redirect()->route('admin.dictionary.operating-system.index')
            ->with('success', 'Operating system updated successfully');
    }

    /**
     * Remove the specified operating system from storage.
     */
    public function destroy(OperatingSystem $operatingSystem): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can delete operating system entries.');
        }

        $operatingSystem->delete();

        return redirect()->route('admin.dictionary.operating-system.index')
            ->with('success', 'Operating system deleted successfully');
    }
}
