<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Enums\PermissionEntityTypes;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Portfolio\StoreCertificatesRequest;
use App\Http\Requests\Portfolio\UpdateCertificatesRequest;
use App\Models\Portfolio\Certificate;
use App\Models\System\Owner;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
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
        readGate(PermissionEntityTypes::RESOURCE, 'certificate', $this->admin);

        $perPage = $request->query('per_page', $this->perPage());

        $certificates = Certificate::searchQuery($request->all(), !empty($this->owner->root) ? null : $this->owner)
            ->orderBy('owner_id')
            ->orderBy('name')
            ->paginate($perPage)->appends(request()->except('page'));

        $pageTitle = ($this->isRootAdmin && !empty($owner_id)) ? $this->owner->name . ' Certificates' : 'Certificates';

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
        createGate(PermissionEntityTypes::RESOURCE, 'certificate', $this->admin);

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
        createGate(PermissionEntityTypes::RESOURCE, 'certificate', $this->admin);

        $certificate = Certificate::create($request->validated());

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
        readGate(PermissionEntityTypes::RESOURCE, $certificate, $this->admin);

        list($prev, $next) = Certificate::prevAndNextPages($certificate->id,
            'admin.portfolio.certificate.show',
            $this->owner->id ?? null,
            ['name', 'asc']);

        return view('admin.portfolio.certificate.show', compact('certificate', 'prev', 'next'));
    }

    /**
     * Show the form for editing the specified certificate.
     *
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $certificate = Certificate::findOrFail($id);

        updateGate(PermissionEntityTypes::RESOURCE, $certificate, $this->admin);

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

        updateGate(PermissionEntityTypes::RESOURCE, $certificate, $this->admin);

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
        deleteGate(PermissionEntityTypes::RESOURCE, $certificate, $this->admin);

        $certificate->delete();

        return redirect(referer('admin.portfolio.certificate.index'))
            ->with('success', $certificate->name . ' certificate deleted successfully.');
    }
}
