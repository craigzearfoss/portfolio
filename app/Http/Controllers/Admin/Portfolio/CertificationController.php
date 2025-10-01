<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Portfolio\CertificationStoreRequest;
use App\Http\Requests\Portfolio\CertificationUpdateRequest;
use App\Models\Portfolio\Certification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

/**
 *
 */
class CertificationController extends BaseController
{
    /**
     * Display a listing of certifications.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $perPage = $request->query('per_page', $this->perPage);

        $certifications = Certification::orderBy('name', 'asc')->paginate($perPage);

        return view('admin.portfolio.certification.index', compact('certifications'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new certification.
     *
     * @return View
     */
    public function create(): View
    {
        return view('admin.portfolio.certification.create');
    }

    /**
     * Store a newly created certification in storage.
     *
     * @param CertificationStoreRequest $certificationStoreRequest
     * @return RedirectResponse
     */
    public function store(CertificationStoreRequest $certificationStoreRequest): RedirectResponse
    {
        $certification = Certification::create($certificationStoreRequest->validated());

        return redirect(referer('admin.portfolio.certification.index'))
            ->with('success', $certification->name . ' certification added successfully.');
    }

    /**
     * Display the specified certification.
     *
     * @param Certification $certification
     * @return View
     */
    public function show(Certification $certification): View
    {
        return view('admin.portfolio.certification.show', compact('certification'));
    }

    /**
     * Show the form for editing the specified certification.
     *
     * @param Certification $certification
     * @return View
     */
    public function edit(Certification $certification): View
    {
        return view('admin.portfolio.certification.edit', compact('certification'));
    }

    /**
     * Update the specified certification in storage.
     *
     * @param CertificationUpdateRequest $request
     * @param Certification $certification
     * @return RedirectResponse
     */
    public function update(CertificationUpdateRequest $request, Certification $certification): RedirectResponse
    {
        $certification->update($request->validated());

        return redirect(referer('admin.portfolio.certification.index'))
            ->with('success', $certification->name . ' certification updated successfully.');
    }

    /**
     * Remove the specified certification from storage.
     *
     * @param Certification $certification
     * @return RedirectResponse
     */
    public function destroy(Certification $certification): RedirectResponse
    {
        $certification->delete();

        return redirect(referer('admin.portfolio.certification.index'))
            ->with('success', $certification->name . ' certification deleted successfully.');
    }
}
