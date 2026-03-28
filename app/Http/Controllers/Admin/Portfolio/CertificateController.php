<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Portfolio\StoreCertificatesRequest;
use App\Http\Requests\Portfolio\UpdateCertificatesRequest;
use App\Models\Portfolio\Certificate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 *
 */
class CertificateController extends BaseAdminController
{
    /**
     * Display a listing of certificate.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        readGate(Certificate::class, $this->admin);

        $perPage = $request->query('per_page', $this->perPage());

        // by default, root admins display all certificates
        $owner = ($this->owner && ($this->owner['id'] !== $this->admin['id'])) ? $this->owner : null;

        $certificates = new Certificate()->searchQuery(request()->except('id'), $owner)
            ->orderBy('owner_id')
            ->orderBy('name')
            ->paginate($perPage)->appends(request()->except('page'));

        $pageTitle = ($owner->name  ?? '') . ' certificates';

        return view('admin.portfolio.certificate.index', compact('certificates', 'pageTitle'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new certificate.
     *
     * @return View
     */
    public function create(): View
    {
        createGate(Certificate::class, $this->admin);

        return view('admin.portfolio.certificate.create');
    }

    /**
     * Store a newly created certificate in storage.
     *
     * @param StoreCertificatesRequest $request
     * @return RedirectResponse
     */
    public function store(StoreCertificatesRequest $request): RedirectResponse
    {
        createGate(Certificate::class, $this->admin);

        $certificate = new Certificate()->create($request->validated());

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
        readGate($certificate, $this->admin);

        list($prev, $next) = $certificate->prevAndNextPages(
            $certificate['id'],
            'admin.portfolio.certificate.show',
            $this->owner ?? null,
            [ 'name', 'asc' ]
        );

        return view('admin.portfolio.certificate.show', compact('certificate', 'prev', 'next'));
    }

    /**
     * Show the form for editing the specified certificate.
     *
     * @param Certificate $certificate
     * @return View
     */
    public function edit(Certificate $certificate): View
    {
        updateGate($certificate, $this->admin);

        return view('admin.portfolio.certificate.edit', compact('certificate'));
    }

    /**
     * Update the specified certificate in storage.
     *
     * @param UpdateCertificatesRequest $request
     * @param Certificate $certificate
     * @return RedirectResponse
     */
    public function update(UpdateCertificatesRequest $request,
                           Certificate               $certificate): RedirectResponse
    {
        $certificate->update($request->validated());

        updateGate($certificate, $this->admin);

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
        deleteGate($certificate, $this->admin);

        $certificate->delete();

        return redirect(referer('admin.portfolio.certificate.index'))
            ->with('success', $certificate->name . ' certificate deleted successfully.');
    }
}
