<?php

namespace App\Http\Controllers\Admin\Dictionary;

use App\Enums\PermissionEntityTypes;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Dictionary\StoreFrameworksRequest;
use App\Http\Requests\Dictionary\UpdateFrameworksRequest;
use App\Models\Dictionary\Category;
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
    protected $PAGINATION_PER_PAGE = 30;

    /**
     * Display a listing of frameworks.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        readGate(PermissionEntityTypes::RESOURCE, 'framework', $this->admin);

        $perPage = $request->query('per_page', $this->perPage());

        $frameworks = Category::searchQuery($request->all())
            ->orderBy('name', 'asc')
            ->paginate($perPage)->appends(request()->except('page'));

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
     * @param StoreFrameworksRequest $request
     * @return RedirectResponse
     */
    public function store(StoreFrameworksRequest $request): RedirectResponse
    {
        if (!isRootAdmin()) {
            abort(403, 'Only admins with root access can add frameworks.');
        }

        $framework = Framework::create($request->validated());

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
        readGate(PermissionEntityTypes::RESOURCE, $framework, $this->admin);

        list($prev, $next) = Framework::prevAndNextPages($framework->id,
            'admin.dictionary.framework.show',
            null,
            ['full_name', 'asc']);

        return view('admin.dictionary.framework.show', compact('framework', 'prev', 'next'));
    }

    /**
     * Show the form for editing the specified framework.
     *
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        if (!isRootAdmin()) {
            abort(403, 'Only admins with root access can update frameworks.');
        }

        $framework = Framework::findOrFail($id);

        return view('admin.dictionary.framework.edit', compact('framework'));
    }

    /**
     * Update the specified framework in storage.
     *
     * @param UpdateFrameworksRequest $request
     * @param Framework $framework
     * @return RedirectResponse
     */
    public function update(UpdateFrameworksRequest $request, Framework $framework): RedirectResponse
    {
        if (!isRootAdmin()) {
            abort(403, 'Only admins with root access can update frameworks.');
        }

        $framework->update($request->validated());

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
        if (!isRootAdmin()) {
            abort(403, 'Only admins with root access can delete a framework.');
        }

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
