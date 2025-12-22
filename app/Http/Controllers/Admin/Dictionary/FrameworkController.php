<?php

namespace App\Http\Controllers\Admin\Dictionary;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Dictionary\StoreFrameworksRequest;
use App\Http\Requests\Dictionary\UpdateFrameworksRequest;
use App\Models\Dictionary\Framework;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Illuminate\Support\Str;

/**
 *
 */
class FrameworkController extends BaseAdminController
{
    /**
     * Display a listing of frameworks.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $perPage = $request->query('per_page', $this->perPage);

        $frameworks = Framework::orderBy('name', 'asc')->paginate($perPage);

        return view('admin.dictionary.framework.index', compact('frameworks'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new framework.
     *
     * @return View
     */
    public function create(): View
    {
        if (!isRootAdmin()) {
            abort(403, 'Only admins with root access can add frameworks.');
        }

        return view('admin.dictionary.framework.create');
    }

    /**
     * Store a newly created framework in storage.
     *
     * @param StoreFrameworksRequest $storeFrameworksRequest
     * @return RedirectResponse
     */
    public function store(StoreFrameworksRequest $storeFrameworksRequest): RedirectResponse
    {
        if (!isRootAdmin()) {
            abort(403, 'Only admins with root access can add frameworks.');
        }

        $framework = Framework::create($storeFrameworksRequest->validated());

        return redirect()->route('admin.dictionary.framework.show', $framework)
            ->with('success', $framework->name . ' successfully added.');
    }

    /**
     * Display the specified framework.
     *
     * @param Framework $framework
     * @return View
     */
    public function show(Framework $framework): View
    {
        return view('admin.dictionary.framework.show', compact('framework'));
    }

    /**
     * Show the form for editing the specified framework.
     *
     * @param Framework $framework
     * @param Request $request
     * @return View
     */
    public function edit(Framework $framework, Request $request): View
    {
        Gate::authorize('update-resource', $framework);

        $referer = $request->headers->get('referer');

        return view('admin.dictionary.framework.edit', compact('framework', 'referer'));
    }

    /**
     * Update the specified framework in storage.
     *
     * @param UpdateFrameworksRequest $updateFrameworksRequest
     * @param Framework $framework
     * @return RedirectResponse
     */
    public function update(UpdateFrameworksRequest $updateFrameworksRequest, Framework $framework): RedirectResponse
    {
        Gate::authorize('update-resource', $framework);

        $framework->update($updateFrameworksRequest->validated());

        return redirect()->route('admin.dictionary.framework.show', $framework)
            ->with('success', $framework->name . ' successfully updated.');
    }

    /**
     * Remove the specified framework from storage.
     *
     * @param Framework $framework
     * @param Request $request
     * @return RedirectResponse
     */
    public function destroy(Framework $framework, Request $request): RedirectResponse
    {
        Gate::authorize('delete-resource', $framework);

        $framework->delete();

        $referer = $request->input('referer');

        if (!empty($referer)) {
            return redirect(str_replace(config('app.url'), '', $referer))
                ->with('success', $framework->name . ' deleted successfully.');
        } else {
            return redirect()->route('admin.dictionary.framework.index')
                ->with('success', $framework->name . ' deleted successfully.');
        }
    }
}
