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
        $perPage= $request->query('per_page', $this->perPage);

        $operatingSystems = OperatingSystem::orderBy('name', 'asc')->paginate($perPage);

        return view('admin.dictionary.operating-system.index', compact('operatingSystems'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new operating system.
     *
     * @param Request $request
     * @return View
     */
    public function create(Request $request): View
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can add operating system entries.');
        }

        $referer = Request()->headers->get('referer');

        return view('admin.dictionary.operating-system.create', compact('referer'));
    }

    /**
     * Store a newly created operating system in storage.
     *
     * @param OperatingSystemStoreRequest $request
     * @return RedirectResponse
     */
    public function store(OperatingSystemStoreRequest $request): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can add operating system entries.');
        }

        $operatingSystem = OperatingSystem::create($request->validated());

        $referer = $request->input('referer');

        if (!empty($referer)) {
            return redirect(str_replace(config('app.url'), '', $referer))
                ->with('success', $operatingSystem->name . ' created successfully.');
        } else {
            return redirect()->route('admin.dictionary.operating-system.index')
                ->with('success', $operatingSystem->name . ' created successfully.');
        }
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
     * @param Request $request
     * @return View
     */
    public function edit(OperatingSystem $operatingSystem, Request $request): View
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can edit operating system entries.');
        }

        $referer = $request->headers->get('referer');

        return view('admin.dictionary.operating-system.edit', compact('operatingSystem', 'referer'));
    }

    /**
     * Update the specified operating system in storage.
     *
     * @param OperatingSystemUpdateRequest $request
     * @param OperatingSystem $operatingSystem
     * @return RedirectResponse
     */
    public function update(OperatingSystemUpdateRequest $request, OperatingSystem $operatingSystem): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can update operating system entries.');
        }

        // Validate the posted data and generated slug.
        $validatedData = $request->validated();
        $request->merge([ 'slug' => Str::slug($validatedData['name']) ]);
        $request->validate(['slug' => [ Rule::unique('posts', 'slug') ] ]);
        $operatingSystem->update($request->validated());

        $referer = $request->input('referer');

        if (!empty($referer)) {
            return redirect(str_replace(config('app.url'), '', $referer))
                ->with('success', $operatingSystem->name . ' updated successfully.');
        } else {
            return redirect()->route('admin.dictionary.operating-system.index')
                ->with('success', $operatingSystem->name . ' updated successfully');
        }
    }

    /**
     * Remove the specified operating system from storage.
     *
     * @param OperatingSystem $operatingSystem
     * @param Request $request
     * @return RedirectResponse
     */
    public function destroy(OperatingSystem $operatingSystem, Request $request): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can delete operating system entries.');
        }

        $operatingSystem->delete();

        $referer = $request->input('referer');

        if (!empty($referer)) {
            return redirect(str_replace(config('app.url'), '', $referer))
                ->with('success', $operatingSystem->name . ' deleted successfully.');
        } else {
            return redirect()->route('admin.dictionary.operating-system.index')
                ->with('success', $operatingSystem->name . ' deleted successfully');
        }
    }
}
