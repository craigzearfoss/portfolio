<?php

namespace App\Http\Controllers\Admin\Career;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Career\CompanyContactStoreRequest;
use App\Http\Requests\Career\ContactStoreRequest;
use App\Http\Requests\Career\ContactUpdateRequest;
use App\Http\Requests\Career\rContactUpdateRequest;
use App\Models\Career\Company;
use App\Models\Career\Contact;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

/**
 *
 */
class ContactController extends BaseController
{
    /**
     * Display a listing of contacts.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $perPage = $request->query('per_page', $this->perPage);

        $contacts = Contact::orderBy('name', 'asc')->paginate($perPage);

        return view('admin.career.contact.index', compact('contacts'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new contact.
     *
     * @return View
     */
    public function create(): View
    {
        return view('admin.career.contact.create');
    }

    /**
     * Store a newly created contact in storage.
     *
     * @param ContactStoreRequest $contactStoreRequest
     * @return RedirectResponse
     */
    public function store(ContactStoreRequest $contactStoreRequest): RedirectResponse
    {
        $contact = Contact::create($contactStoreRequest->validated());

        return redirect(referer('admin.career.contact.index'))
            ->with('success', $contact->name . ' added successfully.');
    }

    /**
     * Display the specified contact.
     *
     * @param Contact $contact
     * @return View
     */
    public function show(Contact $contact): View
    {
        return view('admin.career.contact.show', compact('contact'));
    }

    /**
     * Show the form for editing the specified contact.
     *
     * @param Contact $contact
     * @return View
     */
    public function edit(Contact $contact): View
    {
        return view('admin.career.contact.edit', compact('contact'));
    }

    /**
     * Update the specified contact in storage.
     *
     * @param ContactUpdateRequest $contactUpdateRequest
     * @param Contact $contact
     * @return RedirectResponse
     */
    public function update(ContactUpdateRequest $contactUpdateRequest, Contact $contact): RedirectResponse
    {
        $contact->update($contactUpdateRequest->validated());

        return redirect(referer('admin.career.application.index'))
            ->with('success', $contact->name . ' updated successfully.');
    }

    /**
     * Remove the specified contact from storage.
     *
     * @param Contact $contact
     * @return RedirectResponse
     */
    public function destroy(Contact $contact): RedirectResponse
    {
        $contact->delete();

        return redirect(referer('admin.career.contact.index'))
            ->with('success', $contact->name . ' deleted successfully.');
    }

    /**
     * Show the page to add a company to the contact.
     *
     * @param Contact $contact
     * @return View
     */
    public function addCompany(Contact $contact): View
    {
        return view('admin.career.contact.company.add', compact('contact'));
    }

    /**
     * Attach a company to the contact.
     *
     * @param int $contactId
     * @param CompanyContactStoreRequest $companyContactStoreRequest
     * @return RedirectResponse
     */
    public function attachCompany(int $contactId, CompanyContactStoreRequest $companyContactStoreRequest): RedirectResponse
    {
        $contact = Contact::find($contactId);

        $data = $companyContactStoreRequest->validated();

        if (!empty($data['company_id'])) {

            // Attach an existing contact.
            if (!$company = Company::find($data['company_id'])) {
                return redirect(route('admin.career.contact.company.add', $contactId))
                    ->with('error', 'Company ' . $data['company_id'] . ' not found.');
            }
            $contact->companies()->attach($data['company_id']);

        } else {

            // Create a new company and attach it.
            $company = new Company();
            $company->fill($data);
            $company->save();

            $contact->companies()->attach($company->id);
        }

        return redirect(referer('admin.career.contact.index'))
            ->with('success', $company->name . ' successfully added to ' . $contact->name . '.');
    }

    /**
     * Detach the specified company from the contact.
     *
     * @param Contact $contact
     * @param Company $company
     * @return RedirectResponse
     */
    public function detachCompany(Contact $contact, Company $company): RedirectResponse
    {
        $contact->companies()->detach($company->id);

        return redirect(referer('admin.career.contact.index'))
            ->with('success', $company->name . ' deleted successfully removed from ' . $contact->name . '.');
    }
}
