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
     * @param Request $request
     * @return View
     */
    public function create(Request $request): View
    {
        $referer = $request->headers->get('referer');

        return view('admin.portfolio.certification.create', compact('referer'));
    }

    /**
     * Store a newly created certification in storage.
     *
     * @param CertificationStoreRequest $request
     * @return RedirectResponse
     */
    public function store(CertificationStoreRequest $request): RedirectResponse
    {
        $certification = Certification::create($request->validated());

        $referer = $request->input('referer');

        if (!empty($referer)) {
            return redirect(str_replace(config('app.url'), '', $referer))
                ->with('success', $certification->name . ' certification created successfully.');
        } else {
            return redirect()->route('admin.portfolio.certification.index')
                ->with('success', $certification->name . ' certification created successfully.');
        }
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
     * @param Request $request
     * @return View
     */
    public function edit(Certification $certification, Request $request): View
    {
        $referer = $request->headers->get('referer');

        return view('admin.portfolio.certification.edit', compact('certification', 'referer'));
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

        $referer = $request->input('referer');

        if (!empty($referer)) {
            return redirect(str_replace(config('app.url'), '', $referer))
                ->with('success', $certification->name . ' certification updated successfully.');
        } else {
            return redirect()->route('admin.portfolio.certification.index')
                ->with('success', $certification->name . ' certification updated successfully.');
        }
    }

    /**
     * Remove the specified certification from storage.
     *
     * @param Certification $certification
     * @param Request $request
     * @return RedirectResponse
     */
    public function destroy(Certification $certification, Request $request): RedirectResponse
    {
        $certification->delete();

        $referer = $request->input('referer');

        if (!empty($referer)) {
            return redirect(str_replace(config('app.url'), '', $referer))
                ->with('success', $certification->name . ' certification deleted successfully.');
        } else {
            return redirect()->route('admin.portfolio.certification.index')
                ->with('success', $certification->name . ' certification deleted successfully.');
        }
    }
}
