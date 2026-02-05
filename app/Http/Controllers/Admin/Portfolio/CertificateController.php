<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Portfolio\StoreCertificatesRequest;
use App\Http\Requests\Portfolio\UpdateCertificatesRequest;
use App\Models\Portfolio\Certificate;
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
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function index(Request $request): View
    {
        $perPage = $request->query('per_page', $this->perPage());

        if (!empty($this->owner)) {
            $certificates = Certificate::where('owner_id', $this->owner->id)->orderBy('name', 'asc')->paginate($perPage);
        } else {
            $certificates = Certificate::orderBy('name', 'asc')->paginate($perPage);
        }

        $pageTitle = empty($this->owner) ? 'Certificates' : $this->owner->name . ' Certificates';

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
        list($prev, $next) = Certificate::prevAndNextPages($certificate->id,
            'admin.portfolio.certificate.show',
            $this->owner->id ?? null,
            ['name', 'asc']);

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
        if (!isRootAdmin() && ($certificate->owner_id !== Auth::guard('admin')->user()->id)) {
            Abort(403, 'Not Authorized.');
        }
        //@TODO: Get authorization gate working.
        //Gate::authorize('update-resource', $certificate);

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
        if (!isRootAdmin() && ($certificate->owner_id !== Auth::guard('admin')->user()->id)) {
            Abort(403, 'Not Authorized.');
        }
        //@TODO: Get authorization gate working.
        //Gate::authorize('delete-resource', $certificate);

        $certificate->delete();

        return redirect(referer('admin.portfolio.certificate.index'))
            ->with('success', $certificate->name . ' certificate deleted successfully.');
    }
}
