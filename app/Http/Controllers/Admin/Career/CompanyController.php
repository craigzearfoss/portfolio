<?php

namespace App\Http\Controllers\Admin\Career;

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
        $perPage = $request->query('per_page', $this->perPage);

        $companies = Company::orderBy('name', 'asc')->paginate($perPage);

        return view('admin.career.company.index', compact('companies'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new company.
     *
     * @return View
     */
    public function create(): View
    {
        return view('admin.career.company.create');
    }

    /**
     * Store a newly created company in storage.
     *
     * @param StoreCompaniesRequest $storeCompaniesRequest
     * @return RedirectResponse
     */
    public function store(StoreCompaniesRequest $storeCompaniesRequest): RedirectResponse
    {
        $company = Company::create($storeCompaniesRequest->validated());

        $message = $company->name . ' successfully added.';
        if (!empty($storeCompaniesRequest->query('new_application'))) {
            return redirect()->route('admin.career.application.create', ['company_id' => $company->id])
                    ->with('success', $message);
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
        return view('admin.career.company.show', compact('company'));
    }

    /**
     * Show the form for editing the specified company.
     *
     * @param Company $company
     * @return View
     */
    public function edit(Company $company): View
    {
        return view('admin.career.company.edit', compact('company'));
    }

    /**
     * Update the specified company in storage.
     *
     * @param UpdateCompaniesRequest $updateCompaniesRequest
     * @param Company $company
     * @return RedirectResponse
     */
    public function update(UpdateCompaniesRequest $updateCompaniesRequest, Company $company): RedirectResponse
    {
        $company->update($updateCompaniesRequest->validated());

        return redirect(referer('admin.career.company.index'))
            ->with('success', $company->name . ' updated successfully.');
    }

    /**
     * Remove the specified company from storage.
     *
     * @param Company $company
     * @return RedirectResponse
     */
    public function destroy(Company $company): RedirectResponse
    {
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
        return view('admin.career.company.contact.add', compact('company'));
    }

    /**
     * Attach a contact to the company.
     *
     * @param int $companyId
     * @param StoreCompanyContactsRequest $storeCompanyContactsRequest
     * @return RedirectResponse
     */
    public function attachContact(int $companyId, StoreCompanyContactsRequest $storeCompanyContactsRequest): RedirectResponse
    {
        $company = Company::find($companyId);

        $data = $storeCompanyContactsRequest->validated();

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
        $company->contacts()->detach($contact->id);

        return redirect(referer('admin.career.company.index'))
            ->with('success', $contact->name . ' deleted successfully removed from ' . $company->name . '.');
    }
}
