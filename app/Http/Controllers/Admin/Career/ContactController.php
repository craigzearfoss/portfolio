<?php

namespace App\Http\Controllers\Admin\Career;

use App\Http\Controllers\Controller;
use App\Http\Requests\Career\ContactStoreRequest;
use App\Http\Requests\Career\rContactUpdateRequest;
use App\Models\Career\Contact;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ContactController extends Controller
{
    const NUM_PER_PAGE = 20;

    /**
     * Display a listing of contacts.
     */
    public function index(): View
    {
        $contacts = Contact::latest()->paginate(self::NUM_PER_PAGE);

        return view('admin.career.contact.index', compact('contacts'))
            ->with('i', (request()->input('page', 1) - 1) * self::NUM_PER_PAGE);
    }

    /**
     * Show the form for creating a new contact.
     */
    public function create(): View
    {
        return view('admin.career.contact.create');
    }

    /**
     * Store a newly created contact in storage.
     */
    public function store(ContactStoreRequest $request): RedirectResponse
    {
        Contact::create($request->validated());

        return redirect()->route('admin.career.contact.index')
            ->with('success', 'Contact created successfully.');
    }

    /**
     * Display the specified contact.
     */
    public function show(Contact $contact): View
    {
        return view('admin.career.contact.show', compact('contact'));
    }

    /**
     * Show the form for editing the specified contact.
     */
    public function edit(Contact $contact): View
    {
        return view('admin.career.contact.edit', compact('contact'));
    }

    /**
     * Update the specified contact in storage.
     */
    public function update(rContactUpdateRequest $request, Contact $contact): RedirectResponse
    {
        $contact->update($request->validated());

        return redirect()->route('admin.career.contact.index')
            ->with('success', 'Contact updated successfully');
    }

    /**
     * Remove the specified contact from storage.
     */
    public function destroy(Contact $contact): RedirectResponse
    {
        $contact->delete();

        return redirect()->route('admin.career.contact.index')
            ->with('success', 'Contact deleted successfully');
    }
}
