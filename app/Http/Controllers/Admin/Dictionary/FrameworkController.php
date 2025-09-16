<?php

namespace App\Http\Controllers\Admin\Dictionary;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Dictionary\FrameworkStoreRequest;
use App\Http\Requests\Dictionary\FrameworkUpdateRequest;
use App\Models\Dictionary\Framework;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 *
 */
class FrameworkController extends BaseController
{
    /**
     * Display a listing of frameworks.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $perPage= $request->query('per_page', $this->perPage);

        $frameworks = Framework::orderBy('name', 'asc')->paginate($perPage);

        return view('admin.dictionary.framework.index', compact('frameworks'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new framework.
     *
     * @param Request $request
     * @return View
     */
    public function create(Request $request): View
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can add framework entries.');
        }

        $referer = Request()->headers->get('referer');

        return view('admin.dictionary.framework.create', compact('referer'));
    }

    /**
     * Store a newly created framework in storage.
     *
     * @param JobTaskStoreRequest $request
     * @return RedirectResponse
     */
    public function store(FrameworkStoreRequest $request): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can add framework entries.');
        }

        $framework = Framework::create($request->validated());

        $referer = $request->input('referer');

        if (!empty($referer)) {
            return redirect(str_replace(config('app.url'), '', $referer))
                ->with('success', $framework->name . ' created successfully.');
        } else {
            return redirect()->route('admin.dictionary.framework.index')
                ->with('success', $framework->name . ' created successfully.');
        }
    }

    /**
     * Display the specified framework.
     *
     * @param JobCoworker $jobCoworker
     * @return View
     */
    public function show(Framework $framework): View
    {
        return view('admin.dictionary.framework.show', compact('framework'));
    }

    /**
     * Show the form for editing the specified framework.
     *
     * @param JobCoworker $jobCoworker
     * @param Request $request
     * @return View
     */
    public function edit(Framework $framework): View
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can edit framework entries.');
        }

        $referer = $request->headers->get('referer');

        return view('admin.dictionary.framework.edit', compact('framework', 'referer'));
    }

    /**
     * Update the specified framework in storage.
     *
     * @param JobCoworkerUpdateRequest $request
     * @param JobCoworker $jobCoworker
     * @return RedirectResponse
     */
    public function update(FrameworkUpdateRequest $request, Framework $framework): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can update framework entries.');
        }

        // Validate the posted data and generated slug.
        $validatedData = $request->validated();
        $request->merge([ 'slug' => Str::slug($validatedData['name']) ]);
        $request->validate(['slug' => [ Rule::unique('posts', 'slug') ] ]);
        $framework->update($request->validated());

        $referer = $request->input('referer');

        if (!empty($referer)) {
            return redirect(str_replace(config('app.url'), '', $referer))
                ->with('success', $frmework->name . ' updated successfully.');
        } else {
             return redirect()->route('admin.dictionary.framework.index')
                 ->with('success', $frmework->name . ' updated successfully');
        }
    }

    /**
     * Remove the specified framework from storage.
     *
     * @param JobCoworker $jobCoworker
     * @param Request $request
     * @return RedirectResponse
     */
    public function destroy(Framework $framework): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can delete framework entries.');
        }

        $framework->delete();

        $referer = $request->input('referer');

        if (!empty($referer)) {
            return redirect(str_replace(config('app.url'), '', $referer))
                ->with('success', $framework->name . ' deleted successfully.');
        } else {
            return redirect()->route('admin.dictionary.framework.index')
                ->with('success', $framework->name . ' deleted successfully');
        }
    }
}
