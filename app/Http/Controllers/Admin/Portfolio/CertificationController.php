<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Enums\PermissionEntityTypes;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Portfolio\StoreCertificationsRequest;
use App\Http\Requests\Portfolio\UpdateCertificationsRequest;
use App\Models\Portfolio\Certification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

/**
 *
 */
class CertificationController extends BaseAdminController
{
    /**
     * Display a listing of certifications.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        readGate(PermissionEntityTypes::RESOURCE, 'certification', $this->admin);

        $perPage = $request->query('per_page', $this->perPage());

        $certifications = Certification::searchQuery($request->all())
            ->orderBy('name', 'asc')
            ->paginate($perPage)->appends(request()->except('page'));

        $pageTitle = 'Certifications';

        return view('admin.portfolio.certification.index', compact('certifications', 'pageTitle'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new certification.
     *
     * @return View
     */
    public function create(): View
    {
        createGate(PermissionEntityTypes::RESOURCE, 'certification', $this->admin);

        return view('admin.portfolio.certification.create');
    }

    /**
     * Store a newly created certification in storage.
     *
     * @param StoreCertificationsRequest $request
     * @return RedirectResponse
     */
    public function store(StoreCertificationsRequest $request): RedirectResponse
    {
        createGate(PermissionEntityTypes::RESOURCE, 'certification', $this->admin);

        $certification = Certification::create($request->validated());

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
        readGate(PermissionEntityTypes::RESOURCE, $certification, $this->admin);

        list($prev, $next) = Certification::prevAndNextPages($certification->id,
            'admin.portfolio.certification.show',
            $this->owner->id ?? null,
            ['name', 'asc']);

        return view('admin.portfolio.certification.show', compact('certification', 'prev', 'next'));
    }

    /**
     * Show the form for editing the specified certification.
     *
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $certification = Certification::findOrFail($id);

        updateGate(PermissionEntityTypes::RESOURCE, $certification, $this->admin);

        return view('admin.portfolio.certification.edit', compact('certification'));
    }

    /**
     * Update the specified certification in storage.
     *
     * @param UpdateCertificationsRequest $request
     * @param Certification $certification
     * @return RedirectResponse
     */
    public function update(UpdateCertificationsRequest $request, Certification $certification): RedirectResponse
    {
        $certification->update($request->validated());

        updateGate(PermissionEntityTypes::RESOURCE, $certification, $this->admin);

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
        deleteGate(PermissionEntityTypes::RESOURCE, $certification, $this->admin);

        $certification->delete();

        return redirect(route('admin.portfolio.certification.index'))
            ->with('success', $certification->name . ' deleted successfully.');
    }
}
