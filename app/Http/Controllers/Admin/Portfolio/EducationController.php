<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Http\Controllers\Controller;
use App\Http\Requests\Portfolio\StoreEducationsRequest;
use App\Http\Requests\Portfolio\UpdateEducationsRequest;
use App\Models\Portfolio\Education;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

/**
 *
 */
class EducationController extends Controller
{
    /**
     * Display a listing of educations.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $perPage = $request->query('per_page', $this->perPage);

        $educations = Education::orderBy('enrollment_year', 'asc')->paginate($perPage);

        return view('admin.portfolio.education.index', compact('educations'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new education.
     *
     * @return View
     */
    public function create(): View
    {
        return view('admin.portfolio.education.create');
    }

    /**
     * Store a newly created education in storage.
     *
     * @param StoreEducationsRequest $request
     * @return RedirectResponse
     */
    public function store(StoreEducationsRequest $request): RedirectResponse
    {
        $education = Education::create($request->validated());

        return redirect()->route('admin.portfolio.education.show', $education)
            ->with('success', $education->name . ' education successfully added.');
    }

    /**
     * Display the specified education.
     *
     * @param Education $education
     * @return View
     */
    public function show(Education $education): View
    {
        return view('admin.portfolio.education.show', compact('education'));
    }

    /**
     * Show the form for editing the specified education.
     *
     * @param Education $education
     * @return View
     */
    public function edit(Education $education): View
    {
        Gate::authorize('update-resource', $education);

        return view('admin.portfolio.education.edit', compact('education'));
    }

    /**
     * Update the specified education in storage.
     *
     * @param UpdateEducationsRequest $request
     * @param Education $education
     * @return RedirectResponse
     */
    public function update(UpdateEducationsRequest $request,
                           Education               $education): RedirectResponse
    {
        Gate::authorize('update-resource', $education);

        $education->update($request->validated());

        return redirect()->route('admin.portfolio.education.show', $education)
            ->with('success', $education->name . ' education successfully updated.');
    }

    /**
     * Remove the specified education from storage.
     *
     * @param Education $education
     * @return RedirectResponse
     */
    public function destroy(Education $education): RedirectResponse
    {
        Gate::authorize('delete-resource', $education);

        $education->delete();

        return redirect(referer('admin.portfolio.education.index'))
            ->with('success', $education->name . ' education deleted successfully.');
    }
}
