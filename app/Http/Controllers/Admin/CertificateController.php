<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PortfolioCertificateStoreRequest;
use App\Http\Requests\PortfolioCertificateUpdateRequest;
use App\Models\Portfolio\Certificate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CertificateController extends Controller
{
    const NUM_PER_PAGE = 20;

    /**
     * Display a listing of the certificate.
     */
    public function index(): View
    {
        $certificates = Certificate::latest()->paginate(self::NUM_PER_PAGE);

        return view('admin.certificate.index', compact('certificates'))
            ->with('i', (request()->input('page', 1) - 1) * self::NUM_PER_PAGE);
    }

    /**
     * Show the form for creating a new certificate.
     */
    public function create(): View
    {
        return view('admin.certificate.create');
    }

    /**
     * Store a newly created certificate in storage.
     */
    public function store(PortfolioCertificateStoreRequest $request): RedirectResponse
    {
        Certificate::create($request->validated());

        return redirect()->route('admin.certificate.index')
            ->with('success', 'Certificate created successfully.');
    }

    /**
     * Display the specified certificate.
     */
    public function show(Certificate $certificate): View
    {
        return view('admin.certificate.show', compact('certificate'));
    }

    /**
     * Show the form for editing the specified certificate.
     */
    public function edit(Certificate $certificate): View
    {
        return view('admin.certificate.edit', compact('certificate'));
    }

    /**
     * Update the specified certificate in storage.
     */
    public function update(PortfolioCertificateUpdateRequest $request, Certificate $certificate): RedirectResponse
    {
        dd($request);

        $certificate->update($request->validated());

        return redirect()->route('admin.certificate.index')
            ->with('success', 'Certificate updated successfully');
    }

    /**
     * Remove the specified certificate from storage.
     */
    public function destroy(Certificate $certificate): RedirectResponse
    {
        $certificate->delete();

        return redirect()->route('user.link.index')
            ->with('success', 'Certificate deleted successfully');
    }
}
