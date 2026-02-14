<?php

namespace App\Http\Controllers\Admin\Career;

use App\Enums\PermissionEntityTypes;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Career\StoreCompanyContactsRequest;
use App\Http\Requests\Career\StoreContactsRequest;
use App\Http\Requests\Career\UpdateContactsRequest;
use App\Models\Career\Company;
use App\Models\Career\Contact;
use App\Models\System\Owner;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

/**
 *
 */
class ContactController extends BaseAdminController
{
    /**
     * Display a listing of contacts.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        readGate(PermissionEntityTypes::RESOURCE, 'contact', $this->admin);

        $perPage = $request->query('per_page', $this->perPage());

        $contacts = Contact::searchQuery($request->all(), !empty($this->owner->root) ? null : $this->owner)
            ->orderBy('owner_id')
            ->orderBy('name')
            ->paginate($perPage)->appends(request()->except('page'));

        $pageTitle = ($this->isRootAdmin && !empty($owner_id)) ? $this->owner->name . ' Contacts' : 'Contacts';

        return view('admin.career.contact.index', compact('contacts', 'pageTitle'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new contact.
     *
     * @return View
     */
    public function create(): View
    {
        createGate(PermissionEntityTypes::RESOURCE, 'contact', $this->admin);

        return view('admin.career.contact.create');
    }

    /**
     * Store a newly created contact in storage.
     *
     * @param StoreContactsRequest $request
     * @return RedirectResponse
     */
    public function store(StoreContactsRequest $request): RedirectResponse
    {
        createGate(PermissionEntityTypes::RESOURCE, 'contact', $this->admin);

        $contact = Contact::create($request->validated());

        return redirect()->route('admin.career.contact.show', $contact)
            ->with('success', $contact->name . ' successfully added.');
    }

    /**
     * Display the specified contact.
     *
     * @param Contact $contact
     * @return View
     */
    public function show(Contact $contact): View
    {
        readGate(PermissionEntityTypes::RESOURCE, $contact, $this->admin);

        list($prev, $next) = Contact::prevAndNextPages($contact->id,
            'admin.career.contact.show',
            $this->owner->id ?? null,
            ['name', 'asc']);

        return view('admin.career.contact.show', compact('contact', 'prev', 'next'));
    }

    /**
     * Show the form for editing the specified contact.
     *
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $contact = Contact::findOrFail($id);

        updateGate(PermissionEntityTypes::RESOURCE, $contact, $this->admin);

        return view('admin.career.contact.edit', compact('contact'));
    }

    /**
     * Update the specified contact in storage.
     *
     * @param UpdateContactsRequest $request
     * @param Contact $contact
     * @return RedirectResponse
     */
    public function update(UpdateContactsRequest $request, Contact $contact): RedirectResponse
    {
        $contact->update($request->validated());

        updateGate(PermissionEntityTypes::RESOURCE, $contact, $this->admin);

        return redirect()->route('admin.career.application.show', $contact)
            ->with('success', $contact->name . ' successfully updated.');
    }

    /**
     * Remove the specified contact from storage.
     *
     * @param Contact $contact
     * @return RedirectResponse
     */
    public function destroy(Contact $contact): RedirectResponse
    {
        deleteGate(PermissionEntityTypes::RESOURCE, $contact, $this->admin);

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
        updateGate(PermissionEntityTypes::RESOURCE, $contact, $this->admin);

        return view('admin.career.contact.company.add', compact('contact'));
    }

    /**
     * Attach a company to the contact.
     *
     * @param int $contactId
     * @param StoreCompanyContactsRequest $request
     * @return RedirectResponse
     */
    public function attachCompany(int $contactId, StoreCompanyContactsRequest $request): RedirectResponse
    {
        $contact = Contact::find($contactId);

        updateGate(PermissionEntityTypes::RESOURCE, $contact, $this->admin);

        $data = $request->validated();

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
        updateGate(PermissionEntityTypes::RESOURCE, $contact, $this->admin);

        $contact->companies()->detach($company->id);

        return redirect(referer('admin.career.contact.index'))
            ->with('success', $company->name . ' deleted successfully removed from ' . $contact->name . '.');
    }
}
