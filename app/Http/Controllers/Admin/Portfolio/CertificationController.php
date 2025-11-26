<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Http\Controllers\Controller;
use App\Http\Requests\Portfolio\StoreCertificationsRequest;
use App\Http\Requests\Portfolio\UpdateCertificationsRequest;
use App\Models\Portfolio\Certification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 *
 */
class CertificationController extends Controller
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
        if (!isRootAdmin()) {
            abort(403, 'Only admins with root access can add certifications.');
        }

        return view('admin.portfolio.certification.create');
    }

    /**
     * Store a newly created certification in storage.
     *
     * @param StoreCertificationsRequest $storeCertificationsRequest
     * @return RedirectResponse
     */
    public function store(StoreCertificationsRequest $storeCertificationsRequest): RedirectResponse
    {
        if (!isRootAdmin()) {
            abort(403, 'Only admins with root access can add certifications.');
        }

        $certification = Certification::create($storeCertificationsRequest->validated());

        return redirect()->route('admin.portfolio.certification.show', $certification)
            ->with('success', $certification->name . ' successfully added.');
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
        if (!isRootAdmin()) {
            abort(403, 'Only admins with root access can edit certifications.');
        }

        return view('admin.portfolio.certification.edit', compact('certification'));
    }

    /**
     * Update the specified certification in storage.
     *
     * @param UpdateCertificationsRequest $updateCertificationsRequest
     * @param Certification $certification
     * @return RedirectResponse
     */
    public function update(UpdateCertificationsRequest $updateCertificationsRequest, Certification $certification): RedirectResponse
    {
        if (!isRootAdmin()) {
            abort(403, 'Only admins with root access can update certifications.');
        }

        $certification->update($updateCertificationsRequest->validated());

        return redirect()->route('admin.portfolio.certification.show', $certification)
            ->with('success', $certification->name . ' successfully updated.');
    }

    /**
     * Remove the specified certification from storage.
     *
     * @param Certification $certification
     * @return RedirectResponse
     */
    public function destroy(Certification $certification): RedirectResponse
    {
        if (!isRootAdmin()) {
            abort(403, 'Only admins with root access can delete certifications.');
        }

        $certification->delete();

        return redirect(route('admin.portfolio.certification.index'))
            ->with('success', $certification->name . ' deleted successfully.');
    }
}
