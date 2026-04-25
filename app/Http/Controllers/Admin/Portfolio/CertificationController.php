<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Exports\Portfolio\CertificatesExport;
use App\Exports\Portfolio\CertificationsExport;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Portfolio\StoreCertificationsRequest;
use App\Http\Requests\Portfolio\UpdateCertificationsRequest;
use App\Models\Portfolio\Certification;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

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
     * @throws Exception
     */
    public function index(Request $request): View
    {
        readGate(Certification::class, $this->admin);

        $perPage = $request->query('per_page', $this->perPage());

        $certifications = new Certification()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', Certification::SEARCH_ORDER_BY)
        )
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
        createGate(Certification::class, $this->admin);

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
        createGate(Certification::class, $this->admin);

        $certification = Certification::query()->create($request->validated());

        if ($referer = $request->get('referer')) {
            return redirect($referer)->with('success', $certification['name'] . ' successfully added.');
        } else {
            return redirect()->route('admin.portfolio.certification.show', $certification)
                ->with('success', $certification['name'] . ' successfully added.');
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
        readGate($certification, $this->admin);

        list($prev, $next) = $certification->prevAndNextPages(
            $certification['id'],
            'admin.portfolio.certification.show',
            $this->owner ?? null,
            [ 'name', 'asc' ]
        );

        return view('admin.portfolio.certification.show', compact('certification', 'prev', 'next'));
    }

    /**
     * Show the form for editing the specified certification.
     *
     * @param Certification $certification
     * @return View
     */
    public function edit(Certification $certification): View
    {
        updateGate($certification, $this->admin);

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

        updateGate($certification, $this->admin);

        if ($referer = $request->get('referer')) {
            return redirect($referer)->with('success', $certification['name'] . ' successfully updated.');
        } else {
            return redirect()->route('admin.portfolio.certification.show', $certification)
                ->with('success', $certification['name'] . ' successfully updated.');
        }
    }

    /**
     * Remove the specified certification from storage.
     *
     * @param Certification $certification
     * @return RedirectResponse
     */
    public function destroy(Certification $certification): RedirectResponse
    {
        deleteGate($certification, $this->admin);

        $certification->delete();

        return redirect(route('admin.portfolio.certification.index'))
            ->with('success', $certification['name'] . ' deleted successfully.');
    }

    /**
     * @return BinaryFileResponse
     */
    public function export(): BinaryFileResponse
    {
        $filename = request()->has('timestamp')
            ? 'certifications_' . date("Y-m-d-His") . '.xlsx'
            : 'certifications.xlsx';

        return Excel::download(new CertificationsExport(), $filename);
    }
}
