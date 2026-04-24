<?php

namespace App\Http\Controllers\Admin\Career;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Career\StoreCompanyContactsRequest;
use App\Http\Requests\Career\StoreContactsRequest;
use App\Http\Requests\Career\UpdateContactsRequest;
use App\Models\Career\Company;
use App\Models\Career\CompanyContact;
use App\Models\Career\Contact;
use App\Models\Career\Resume;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
     * @throws Exception
     */
    public function index(Request $request): View
    {
        readGate(Contact::class, $this->admin);

        $perPage = $request->query('per_page', $this->perPage());

        $contacts = new Contact()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', Contact::SEARCH_ORDER_BY),
            $this->singleAdminMode || !$this->isRootAdmin ? $this->admin : null
        )
        ->paginate($perPage)->appends(request()->except('page'));

        $pageTitle = ($this->owner->name  ?? '') . ' Contacts';

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
        createGate(Contact::class, $this->admin);

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
        createGate(Contact::class, $this->admin);

        $contact = null;
        $error = null;

        if ($companyId = $request->get('company_id')) {
            if (!Company::query()->find($companyId)) {
                $error = 'Company ' . $companyId . ' not found';
            }
        }

        if (empty($error)) {

            // create the contact
            $contact = Contact::query()->create($request->validated());

            // attach the contact to the company
            if (!empty($companyId)) {
                CompanyContact::query()->insert([
                    'owner_id'   => $contact->owner_id,
                    'contact_id' => $contact->id,
                    'company_id' => $companyId,
                    'active'     => true,
                ]);
            }
        }

        if ($referer = $request->get('referer')) {
            return redirect($referer)->with('success', $contact['name'] . ' successfully added.');
        } else {
            return redirect()->route('admin.career.contact.show', $contact)
                ->with('success', $contact->name . ' successfully added.');
        }
    }

    /**
     * Display the specified contact.
     *
     * @param Contact $contact
     * @return View
     */
    public function show(Contact $contact): View
    {
        readGate($contact, $this->admin);

        list($prev, $next) = $contact->prevAndNextPages(
            $contact['id'],
            'admin.career.contact.show',
            $this->owner ?? null,
            [ 'name', 'asc' ]
        );

        return view('admin.career.contact.show', compact('contact', 'prev', 'next'));
    }

    /**
     * Show the form for editing the specified contact.
     *
     * @param Contact $contact
     * @return View
     */
    public function edit(Contact $contact): View
    {
        updateGate($contact, $this->admin);

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

        updateGate($contact, $this->admin);

        if ($referer = $request->get('referer')) {
            return redirect($referer)->with('success', $contact['name'] . ' successfully updated.');
        } else {
            return redirect()->route('admin.career.application.show', $contact)
                ->with('success', $contact->name . ' successfully updated.');
        }
    }

    /**
     * Remove the specified contact from storage.
     *
     * @param Contact $contact
     * @return RedirectResponse
     */
    public function destroy(Contact $contact): RedirectResponse
    {
        deleteGate($contact, $this->admin);

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
        updateGate($contact, $this->admin);

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
        $contact = Contact::query()->find($contactId);

        updateGate($contact, $this->admin);

        $data = $request->validated();

        if (!empty($data['company_id'])) {

            // Attach an existing contact.
            if (!$company = Company::query()->find($data['company_id'])) {
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
        updateGate($contact, $this->admin);

        $contact->companies()->detach($company->id);

        return redirect(referer('admin.career.contact.index'))
            ->with('success', $company->name . ' deleted successfully removed from ' . $contact->name . '.');
    }
}
