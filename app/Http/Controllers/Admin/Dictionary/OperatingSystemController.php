<?php

namespace App\Http\Controllers\Admin\Dictionary;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Dictionary\OperatingSystemStoreRequest;
use App\Http\Requests\Dictionary\OperatingSystemUpdateRequest;
use App\Models\Dictionary\OperatingSystem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Illuminate\Support\Str;

/**
 *
 */
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
        $perPage = $request->query('per_page', $this->perPage);

        $operatingSystems = OperatingSystem::orderBy('name', 'asc')->paginate($perPage);

        return view('admin.dictionary.operating-system.index', compact('operatingSystems'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new operating system.
     *
     * @return View
     */
    public function create(): View
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can add operating systems.');
        }

        return view('admin.dictionary.operating-system.create');
    }

    /**
     * Store a newly created operating system in storage.
     *
     * @param OperatingSystemStoreRequest $operatingSystemStoreRequest
     * @return RedirectResponse
     */
    public function store(OperatingSystemStoreRequest $operatingSystemStoreRequest): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can add operating systems.');
        }

        $operatingSystem = OperatingSystem::create($operatingSystemStoreRequest->validated());

        return redirect(referer('admin.dictionary.index'))
            ->with('success', $operatingSystem->name . ' added successfully.');
    }

    /**
     * Display the specified operating system.
     *
     * @param OperatingSystem $operatingSystem
     * @return View
     */
    public function show(OperatingSystem $operatingSystem): View
    {
        return view('admin.dictionary.operating-system.show', compact('operatingSystem'));
    }

    /**
     * Show the form for editing the specified operating system.
     *
     * @param OperatingSystem $operatingSystem
     * @return View
     */
    public function edit(OperatingSystem $operatingSystem): View
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can edit operating systems.');
        }

        return view('admin.dictionary.operating-system.edit', compact('operatingSystem'));
    }

    /**
     * Update the specified operating system in storage.
     *
     * @param OperatingSystemUpdateRequest $operatingSystemUpdateRequest
     * @param OperatingSystem $operatingSystem
     * @return RedirectResponse
     */
    public function update(OperatingSystemUpdateRequest $operatingSystemUpdateRequest,
                           OperatingSystem $operatingSystem): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can update operating systems.');
        }

        $operatingSystem->update($operatingSystemUpdateRequest->validated());

        return redirect(referer('admin.dictionary.index'))
            ->with('success', $operatingSystem->name . ' updated successfully.');
    }

    /**
     * Remove the specified operating system from storage.
     *
     * @param OperatingSystem $operatingSystem
     * @return RedirectResponse
     */
    public function destroy(OperatingSystem $operatingSystem): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can delete operating systems.');
        }

        $operatingSystem->delete();

        return redirect(referer('admin.dictionary.index'))
            ->with('success', $operatingSystem->name . ' deleted successfully.');
    }
}
