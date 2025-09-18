<?php

namespace App\Http\Controllers\Admin\Career;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Career\ContactStoreRequest;
use App\Http\Requests\Career\ContactUpdateRequest;
use App\Http\Requests\Career\rContactUpdateRequest;
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

        $contacts = Contact::latest()->paginate($perPage);

        return view('admin.career.contact.index', compact('contacts'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new contact.
     *
     * @param Request $request
     * @return View
     */
    public function create(Request $request): View
    {
        $referer = $request->headers->get('referer');

        return view('admin.career.contact.create', compact('referer'));
    }

    /**
     * Store a newly created contact in storage.
     *
     * @param ContactStoreRequest $request
     * @return RedirectResponse
     */
    public function store(ContactStoreRequest $request): RedirectResponse
    {
        $contact = Contact::create($request->validated());

        $referer = $request->input('referer');

        if (!empty($referer)) {
            return redirect(str_replace(config('app.url'), '', $referer))
                ->with('success', $contact->name . ' created successfully.');
        } else {
            return redirect()->route('admin.career.contact.index')
                ->with('success', $contact->name . ' created successfully.');
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
        return view('admin.career.contact.show', compact('contact'));
    }

    /**
     * Show the form for editing the specified contact.
     *
     * @param Contact $contact
     * @param Request $request
     * @return View
     */
    public function edit(Contact $contact, Request $request): View
    {
        $referer = $request->headers->get('referer');

        return view('admin.career.contact.edit', compact('contact', 'referer'));
    }

    /**
     * Update the specified contact in storage.
     *
     * @param ContactUpdateRequest $request
     * @param Contact $contact
     * @return RedirectResponse
     */
    public function update(ContactUpdateRequest $request, Contact $contact): RedirectResponse
    {
        $contact->update($request->validated());

        $referer = $request->input('referer');

        if (!empty($referer)) {
            return redirect(str_replace(config('app.url'), '', $referer))
                ->with('success', $contact->name . ' updated successfully.');
        } else {
            return redirect()->route('admin.career.application.index')
                ->with('success', $contact->name . ' updated successfully.');
        }
    }

    /**
     * Remove the specified contact from storage.
     *
     * @param Contact $contact
     * @param Request $request
     * @return RedirectResponse
     */
    public function destroy(Contact $contact, Request $request): RedirectResponse
    {
        $contact->delete();

        $referer = $request->input('referer');

        if (!empty($referer)) {
            return redirect(str_replace(config('app.url'), '', $referer))
                ->with('success', $contact->name . ' deleted successfully.');
        } else {
            return redirect()->route('admin.career.contact.index')
                ->with('success', $contact->name . ' deleted successfully.');
        }
    }
}
