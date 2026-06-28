<?php

namespace App\Http\Controllers\Admin\Career;

use App\Enums\EnvTypes;
use App\Exports\Career\ReferencesExport;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Career\StoreCompanyReferencesRequest;
use App\Http\Requests\Career\StoreReferencesRequest;
use App\Http\Requests\Career\UpdateReferencesRequest;
use App\Models\Career\Company;
use App\Models\Career\CompanyReference;
use App\Models\Career\Reference;
use App\Services\PermissionService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

/**
 *
 */
class ReferenceController extends BaseAdminController
{
    public function __construct(PermissionService $permissionService)
    {
        parent::__construct($permissionService, EnvTypes::ADMIN);

        view()->share('resourceType', 'career.reference');
    }

    /**
     * Display a listing of references.
     *
     * @param Request $request
     * @return View
     * @throws Exception
     */
    public function index(Request $request): View
    {
        readGate(Reference::class, $this->admin);

        $perPage = $request->query('per_page', $this->perPage());

        $references = new Reference()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', Reference::SEARCH_ORDER_BY),
            !$this->isRootAdmin ? $this->admin : null
        )
        ->paginate($perPage)->appends(request()->except('page'));

        $pageTitle = 'References';

        return view('admin.career.reference.index', compact('references', 'pageTitle'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new reference.
     *
     * @return View
     */
    public function create(): View
    {
        createGate(Reference::class, $this->admin);

        $company_id = request()->query('company_id', null);
        $reference_id = request()->query('reference_id', null);

        return view('admin.career.reference.create', compact('company_id', 'reference_id'));
    }

    /**
     * Store a newly created reference in storage.
     *
     * @param StoreReferencesRequest $request
     * @return RedirectResponse
     */
    public function store(StoreReferencesRequest $request): RedirectResponse
    {
        createGate(Reference::class, $this->admin);

        $reference = null;
        $error = null;

        if ($companyId = $request->input('company_id')) {
            if (!$companyId = Company::query()->find($companyId)) {
                $error = 'Company ' . $companyId . ' not found';
            }
        }

        if (empty($error)) {

            // create the reference
            $reference = Reference::query()->create($request->validated());

            // attach the reference to the company (if one was specified)
            if (!empty($companyId)) {
                CompanyReference::query()->insert([
                    'owner_id'   => $reference->owner_id,
                    'contact_id' => $reference['id'],
                    'company_id' => $companyId,
                    'active'     => true,
                ]);
            }
        }

        if ($referer = $request->input('referer')) {
            return redirect($referer)->with('success', $reference['name'] . ' successfully added.');
        } else {
            return redirect()->route('admin.career.reference.show', $reference)
                ->with('success', $reference['name'] . ' successfully added.');
        }
    }

    /**
     * Display the specified reference.
     *
     * @param Reference $reference
     * @return View
     */
    public function show(Reference $reference): View
    {
        readGate($reference, $this->admin);

        $companies = new CompanyReference()->newQuery()->where('id', $reference->id)
            ->leftJoin(dbName('career_db' ) . '.companies', 'companies.id', '=', 'company_reference.company_id')
            ->get();

        list($prev, $next) = $reference->prevAndNextPages(
            $reference['id'],
            'admin.career.reference.show',
            $this->owner ?? null,
            [ 'name', 'asc' ]
        );

        return view('admin.career.reference.show', compact('reference', 'companies', 'prev', 'next'));
    }

    /**
     * Show the form for editing the specified reference.
     *
     * @param Reference $reference
     * @return View
     */
    public function edit(Reference $reference): View
    {
        updateGate($reference, $this->admin);

        return view('admin.career.reference.edit', compact('reference'));
    }

    /**
     * Update the specified reference in storage.
     *
     * @param UpdateReferencesRequest $request
     * @param Reference $reference
     * @return RedirectResponse
     */
    public function update(UpdateReferencesRequest $request, Reference $reference): RedirectResponse
    {
        $reference->update($request->validated());

        updateGate($reference, $this->admin);

        if ($referer = $request->input('referer')) {
            return redirect($referer)->with('success', $reference['name'] . ' successfully updated.');
        } else {
            return redirect()->route('admin.career.reference.show', $reference)
                ->with('success', $reference['name'] . ' successfully updated.');
        }
    }

    /**
     * Remove the specified reference from storage.
     *
     * @param Reference $reference
     * @return RedirectResponse
     */
    public function destroy(Reference $reference): RedirectResponse
    {
        deleteGate( $reference, $this->admin);

        $reference->delete();

        return redirect(referer('admin.career.reference.index'))
            ->with('success', $reference['name'] . ' deleted successfully.');
    }

    /**
     * Show the page to add a company to the reference.
     *
     * @param Reference $reference
     * @return View
     */
    public function addCompany(Reference $reference): View
    {
        updateGate($reference, $this->admin);

        return view('admin.career.reference.company.add', compact('reference'));
    }

    /**
     * Attach a company to the reference.
     *
     * @param int $referenceId
     * @param StoreCompanyReferencesRequest $request
     * @return RedirectResponse
     */
    public function attachCompany(int $referenceId, StoreCompanyReferencesRequest $request): RedirectResponse
    {
        $reference = Reference::query()->find($referenceId);

        updateGate($reference, $this->admin);

        $data = $request->validated();

        if (!empty($data['company_id'])) {

            // Attach an existing reference.
            if (!$company = Company::query()->find($data['company_id'])) {
                return redirect(route('admin.career.reference.company.add', $referenceId))
                    ->with('error', 'Company ' . $data['company_id'] . ' not found.');
            }
            $reference->companies()->attach($data['company_id']);

        } else {

            // Create a new company and attach it.
            $company = new Company();
            $company->fill($data);
            $company->save();

            $reference->companies()->attach($company->id);
        }

        return redirect(referer('admin.career.reference.index'))
            ->with('success', $reference->name . ' successfully added to ' . $reference->name . '.');
    }

    /**
     * Detach the specified company from the reference.
     *
     * @param Reference $reference
     * @param Company $company
     * @return RedirectResponse
     */
    public function detachCompany(Reference $reference, Company $company): RedirectResponse
    {
        updateGate($reference, $this->admin);

        $reference->companies()->detach($company->id);

        return redirect(referer('admin.career.reference.index'))
            ->with('success', $company->name . ' deleted successfully removed from ' . $reference->name . '.');
    }

    /**
     * Export Microsoft Excel file.
     *
     * @return BinaryFileResponse
     */
    public function export(): BinaryFileResponse
    {
        readGate(Reference::class, $this->admin);

        $filename = request()->has('timestamp')
            ? 'references_' . date("Y-m-d-His") . '.xlsx'
            : 'references.xlsx';

        return Excel::download(new ReferencesExport(), $filename);
    }
}
