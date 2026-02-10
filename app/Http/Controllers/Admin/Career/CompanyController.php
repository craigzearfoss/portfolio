<?php

namespace App\Http\Controllers\Admin\Career;

use App\Enums\PermissionEntityTypes;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\System\StoreAdminsRequest;
use App\Http\Requests\Career\StoreCompanyContactsRequest;
use App\Http\Requests\Career\StoreCompaniesRequest;
use App\Http\Requests\Career\UpdateCompaniesRequest;
use App\Http\Requests\Career\StoreContactsRequest;
use App\Models\Career\Company;
use App\Models\Career\CompanyContact;
use App\Models\Career\Contact;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use function PHPUnit\Framework\throwException;

/**
 *
 */
class CompanyController extends BaseAdminController
{
    /**
     * Display a listing of companies.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        readGate(PermissionEntityTypes::RESOURCE, 'company', $this->admin);

        $perPage = $request->query('per_page', $this->perPage());

        if (!empty($this->owner)) {
            $companies = Company::where('owner_id', $this->owner->id)
                ->orderBy('name', 'asc')->paginate($perPage);
        } else {
            $companies = Company::orderBy('name', 'asc')->paginate($perPage);
        }

        return view('admin.career.company.index', compact('companies'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new company.
     *
     * @param Request $request
     * @return View
     */
    public function create(Request $request): View
    {
        createGate(PermissionEntityTypes::RESOURCE, 'company', $this->admin);

        $urlParams = [];
        if ($newApplication = $request->query('new_application')) $urlParams[ 'new_application'] = 1;
        if ($resumeId = $request->get('resume_id')) $urlParams['resume_id'] = $resumeId;
        if ($coverLetterId = $request->get('cover_letter_id')) $urlParams['cover_letter_id'] = $coverLetterId;
        if ($newApplication = $request->query('new_application')) $urlParams[ 'new_application'] = 1;

        return view('admin.career.company.create', compact('urlParams'));
    }

    /**
     * Store a newly created company in storage.
     *
     * @param StoreCompaniesRequest $request
     * @return RedirectResponse
     */
    public function store(StoreCompaniesRequest $request): RedirectResponse
    {
        $urlParams = [];
        $newApplication = boolval($request->query('new_application'));
        if ($resumeId = $request->query('resume_id')) $urlParams['resume_id'] = $resumeId;
        if ($coverLetterId = $request->query('cover_letter_id')) $urlParams['cover_letter_id'] = $coverLetterId;

        $company = Company::create($request->validated());

        createGate(PermissionEntityTypes::RESOURCE, 'company', $this->admin);

        $message = $company->name . ' successfully added.';
        if ($newApplication) {
            return redirect()->route(
                'admin.career.application.create',
                array_merge(['company_id' => $company->id], $urlParams)
            )->with('success', $message);
        } else {
            return redirect()->route('admin.career.company.show', $company)->with('success', $message);
        }
    }

    /**
     * Display the specified company.
     *
     * @param Company $company
     * @return View
     */
    public function show(Company $company): View
    {
        readGate(PermissionEntityTypes::RESOURCE, $company, $this->admin);

        list($prev, $next) = Company::prevAndNextPages($company->id,
            'admin.career.company.show',
            $this->owner->id ?? null,
            ['name', 'asc']);

        return view('admin.career.company.show', compact('company', 'prev', 'next'));
    }

    /**
     * Show the form for editing the specified company.
     *
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $company = Company::findOrFail($id);

        updateGate(PermissionEntityTypes::RESOURCE, $company, $this->admin);

        return view('admin.career.company.edit', compact('company'));
    }

    /**
     * Update the specified company in storage.
     *
     * @param UpdateCompaniesRequest $request
     * @param Company $company
     * @return RedirectResponse
     */
    public function update(UpdateCompaniesRequest $request, Company $company): RedirectResponse
    {
        $company->update($request->validated());

        updateGate(PermissionEntityTypes::RESOURCE, $company, $this->admin);

        return redirect()->route('admin.career.company.show', $company)
            ->with('success', $company->name . ' successfully updated.');
    }

    /**
     * Remove the specified company from storage.
     *
     * @param Company $company
     * @return RedirectResponse
     */
    public function destroy(Company $company): RedirectResponse
    {
        deleteGate(PermissionEntityTypes::RESOURCE, $company, $this->admin);

        $company->delete();

        return redirect(referer('admin.career.company.index'))
            ->with('success', $company->name . ' deleted successfully.');
    }

    /**
     * Show the page to add a contact to the company.
     *
     * @param Company $company
     * @return View
     */
    public function addContact(Company $company): View
    {
        updateGate(PermissionEntityTypes::RESOURCE, $company, $this->admin);

        return view('admin.career.company.contact.add', compact('company'));
    }

    /**
     * Attach a contact to the company.
     *
     * @param int $companyId
     * @param StoreCompanyContactsRequest $request
     * @return RedirectResponse
     */
    public function attachContact(int $companyId, StoreCompanyContactsRequest $request): RedirectResponse
    {
        updateGate(PermissionEntityTypes::RESOURCE, $company, $this->admin);

        $company = Company::find($companyId);

        $data = $request->validated();

        if (!empty($data['contact_id'])) {

            // Attach an existing contact.
            if (!$contact = Contact::find($data['contact_id'])) {
                return redirect(route('admin.career.company.contact.add', $companyId))
                    ->with('error', 'Contact ' . $data['contact_id'] . ' not found.');
            }
            $company->contacts()->attach($data['contact_id']);

        } else {

            // Create a new contact and attach them.
            $contact = new Contact();
            $contact->fill($data);
            $contact->save();

            $company->contacts()->attach($contact->id);
        }

        return redirect(referer('admin.career.company.index'))
            ->with('success', $contact->name . ' successfully added to ' . $company->name . '.');
    }

    /**
     * Detach the specified contact from the company.
     *
     * @param Company $company
     * @param Contact $contact
     * @return RedirectResponse
     */
    public function detachContact(Company $company, Contact $contact): RedirectResponse
    {
        updateGate(PermissionEntityTypes::RESOURCE, $company, $this->admin);

        $company->contacts()->detach($contact->id);

        return redirect(referer('admin.career.company.index'))
            ->with('success', $contact->name . ' deleted successfully removed from ' . $company->name . '.');
    }
}
