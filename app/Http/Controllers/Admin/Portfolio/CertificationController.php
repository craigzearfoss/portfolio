<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Http\Controllers\Controller;
use App\Http\Requests\PortfolioCertificationStoreRequest;
use App\Http\Requests\PortfolioCertificationUpdateRequest;
use App\Models\Portfolio\Certification;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CertificationController extends Controller
{
    const NUM_PER_PAGE = 20;

    /**
     * Display a listing of certifications.
     */
    public function index(): View
    {
        $certifications = Certification::latest()->paginate(self::NUM_PER_PAGE);

        return view('admin.portfolio.certification.index', compact('certifications'))
            ->with('i', (request()->input('page', 1) - 1) * self::NUM_PER_PAGE);
    }

    /**
     * Show the form for creating a new certification.
     */
    public function create(): View
    {
        return view('admin.portfolio.certification.create');
    }

    /**
     * Store a newly created certification in storage.
     */
    public function store(PortfolioCertificationStoreRequest $request): RedirectResponse
    {
        Certification::create($request->validated());

        return redirect()->route('admin.portfolio.certification.index')
            ->with('success', 'Certification created successfully.');
    }

    /**
     * Display the specified certification.
     */
    public function show(Certification $certification): View
    {
        return view('admin.portfolio.certification.show', compact('certification'));
    }

    /**
     * Show the form for editing the specified certification.
     */
    public function edit(Certification $certification): View
    {
        return view('admin.portfolio.certification.edit', compact('certification'));
    }

    /**
     * Update the specified certification in storage.
     */
    public function update(PortfolioCertificationUpdateRequest $request, Certification $certification): RedirectResponse
    {
        dd($request);

        $certification->update($request->validated());

        return redirect()->route('admin.portfolio.certification.index')
            ->with('success', 'Certification updated successfully');
    }

    /**
     * Remove the specified certification from storage.
     */
    public function destroy(Certification $certification): RedirectResponse
    {
        $certification->delete();

        return redirect()->route('admin.portfolio.certification.index')
            ->with('success', 'Certification deleted successfully');
    }
}
