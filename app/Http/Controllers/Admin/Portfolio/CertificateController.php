<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Portfolio\StoreCertificatesRequest;
use App\Http\Requests\Portfolio\UpdateCertificatesRequest;
use App\Models\Portfolio\Certificate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

/**
 *
 */
class CertificateController extends BaseAdminController
{
    /**
     * Display a listing of certificates.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $perPage = $request->query('per_page', $this->perPage);

        $certificates = Certificate::orderBy('name', 'asc')->paginate($perPage);

        return view('admin.portfolio.certificate.index', compact('certificates'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new certificate.
     *
     * @return View
     */
    public function create(): View
    {
        return view('admin.portfolio.certificate.create');
    }

    /**
     * Store a newly created certificate in storage.
     *
     * @param StoreCertificatesRequest $storeCertificatesRequest
     * @return RedirectResponse
     */
    public function store(StoreCertificatesRequest $storeCertificatesRequest): RedirectResponse
    {
        $certificate = Certificate::create($storeCertificatesRequest->validated());

        return redirect()->route('admin.portfolio.certificate.show', $certificate)
            ->with('success', $certificate->name . ' certificate successfully added.');
    }

    /**
     * Display the specified certificate.
     *
     * @param Certificate $certificate
     * @return View
     */
    public function show(Certificate $certificate): View
    {
        return view('admin.portfolio.certificate.show', compact('certificate'));
    }

    /**
     * Show the form for editing the specified certificate.
     *
     * @param Certificate $certificate
     * @return View
     */
    public function edit(Certificate $certificate): View
    {
        Gate::authorize('edit-resource', $certificate);

        return view('admin.portfolio.certificate.edit', compact('certificate'));
    }

    /**
     * Update the specified certificate in storage.
     *
     * @param UpdateCertificatesRequest $updateCertificatesRequest
     * @param Certificate $certificate
     * @return RedirectResponse
     */
    public function update(UpdateCertificatesRequest $updateCertificatesRequest,
                           Certificate               $certificate): RedirectResponse
    {
        Gate::authorize('edit-resource', $certificate);

        $certificate->update($updateCertificatesRequest->validated());

        return redirect()->route('admin.portfolio.certificate.show', $certificate)
            ->with('success', $certificate->name . ' certificate successfully updated.');
    }

    /**
     * Remove the specified certificate from storage.
     *
     * @param Certificate $certificate
     * @return RedirectResponse
     */
    public function destroy(Certificate $certificate): RedirectResponse
    {
        Gate::authorize('delete-resource', $certificate);

        $certificate->delete();

        return redirect(referer('admin.portfolio.certificate.index'))
            ->with('success', $certificate->name . ' certificate deleted successfully.');
    }
}
