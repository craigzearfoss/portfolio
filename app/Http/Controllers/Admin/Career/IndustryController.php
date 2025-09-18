<?php

namespace App\Http\Controllers\Admin\Career;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Career\IndustryStoreRequest;
use App\Http\Requests\Career\IndustryUpdateRequest;
use App\Models\Career\Industry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Illuminate\Support\Str;

/**
 *
 */
class IndustryController extends BaseController
{
    /**
     * Display a listing of industries.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $perPage = $request->query('per_page', $this->perPage);

        $industries = Industry::latest()->paginate($perPage);

        return view('admin.career.industry.index', compact('industries'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new industry.
     *
     * @param Request $request
     * @return View
     */
    public function create(Request $request): View
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can add industries.');
        }

        $referer = $request->headers->get('referer');

        return view('admin.career.industry.create', compact('referer'));
    }

    /**
     * Store a newly created industry in storage.
     *
     * @param IndustryStoreRequest $request
     * @return RedirectResponse
     */
    public function store(IndustryStoreRequest $request): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can add industries.');
        }

        $industry = Industry::create($request->validated());

        $referer = $request->input('referer');

        if (!empty($referer)) {
            return redirect(str_replace(config('app.url'), '', $referer))
                ->with('success', $industry->name . ' created successfully.');
        } else {
            return redirect()->route('admin.career.industry.index')
                ->with('success', $industry->name . ' created successfully.');
        }
    }

    /**
     * Display the specified industry.
     *
     * @param Industry $industry
     * @return View
     */
    public function show(Industry $industry): View
    {
        return view('admin.career.industry.show', compact('industry'));
    }

    /**
     * Show the form for editing the specified industry.
     *
     * @param Industry $industry
     * @param Request $request
     * @return View
     */
    public function edit(Industry $industry, Request $request): View
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can edit industries.');
        }

        $referer = $request->headers->get('referer');

        return view('admin.career.industry.edit', compact('industry', 'referer'));
    }

    /**
     * Update the specified industry in storage.
     *
     * @param IndustryUpdateRequest $request
     * @param Industry $industry
     * @return RedirectResponse
     */
    public function update(IndustryUpdateRequest $request, Industry $industry): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can update industries.');
        }

        // Validate the posted data and generated slug.
        $validatedData = $request->validated();
        $request->merge([ 'slug' => Str::slug($validatedData['name']) ]);
        $request->validate(['slug' => [ Rule::unique('career_db.industries', 'slug') ] ]);
        $industry->update($request->validated());

        $referer = $request->input('referer');

        if (!empty($referer)) {
            return redirect(str_replace(config('app.url'), '', $referer))
                ->with('success', $industry->name . ' updated successfully.');
        } else {
            return redirect()->route('admin.dictionary.database.index')
                ->with('success', $industry->name . ' updated successfully.');
        }
    }

    /**
     * Remove the specified industry from storage.
     *
     * @param Industry $industry
     * @param Request $request
     * @return RedirectResponse
     */
    public function destroy(Industry $industry, Request $request): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can delete industries.');
        }

        $industry->delete();

        $referer = $request->input('referer');

        if (!empty($referer)) {
            return redirect(str_replace(config('app.url'), '', $referer))
                ->with('success', $industry->name . ' deleted successfully.');
        } else {
            return redirect()->route('admin.career.industry.index')
                ->with('success', $industry->name . ' deleted successfully.');
        }
    }
}
