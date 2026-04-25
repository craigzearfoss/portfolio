<?php

namespace App\Http\Controllers\Admin\System;

use App\Exports\System\UserEmailsExport;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\System\StoreUserEmailsRequest;
use App\Http\Requests\System\UpdateUserEmailsRequest;
use App\Models\System\UserEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

/**
 *
 */
class UserEmailController extends BaseAdminController
{
    /**
     * Display a listing of user emails.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        if (!$this->isRootAdmin) {
            readGate(UserEmail::class, $this->user);
        }

        $perPage = $request->query('per_page', $this->perPage());

        $userEmails = new UserEmail()->searchQuery(
            $request->all(),
            request()->input('sort') ?? implode('|', UserEmail::SEARCH_ORDER_BY),
            !$this->isRootAdmin ? $this->user : null
        )
        ->paginate($perPage)->appends(request()->except('page'));

        $pageTitle = ($this->user->name  ?? '') . ' User Email Addresses';

        return view('admin.system.user-email.index', compact('userEmails', 'pageTitle'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new user email.
     *
     * @return View
     */
    public function create(): View
    {
        createGate(UserEmail::class, $this->user);

        return view('admin.system.user-email.create');
    }

    /**
     * Store a newly created user email in storage.
     *
     * @param StoreUserEmailsRequest $request
     * @return RedirectResponse
     */
    public function store(StoreUserEmailsRequest $request): RedirectResponse
    {
        createGate(UserEmail::class, $this->user);

        $userEmail = UserEmail::query()->create($request->validated());

        if ($referer = $request->get('referer')) {
            return redirect($referer)->with('success', $userEmail['name'] . ' successfully added.');
        } else {
            return redirect()->route('admin.system.user-email.show', $userEmail)
                ->with('success', $userEmail['name'] . ' successfully added.');
        }
    }

    /**
     * Display the specified user email.
     *
     * @param UserEmail $userEmail
     * @return View
     */
    public function show(UserEmail $userEmail): View
    {
        readGate($userEmail, $this->user);

        list($prev, $next) = $userEmail->prevAndNextPages(
            $userEmail['id'],
            'admin.system.user-email.show',
            $this->owner ?? null,
            [ 'name', 'asc' ]
        );

        return view('admin.system.user-email.show', compact('userEmail', 'prev', 'next'));
    }

    /**
     * Show the form for editing the specified user email.
     *
     * @param UserEmail $userEmail
     * @return View
     */
    public function edit(UserEmail $userEmail): View
    {
        updateGate($userEmail, $this->user);

        return view('admin.system.user-email.edit', compact('userEmail'));
    }

    /**
     * Update the specified user email in storage.
     *
     * @param UpdateUserEmailsRequest $request
     * @param UserEmail $userEmail
     * @return RedirectResponse
     */
    public function update(UpdateUserEmailsRequest $request, UserEmail $userEmail): RedirectResponse
    {
        $userEmail->update($request->validated());

        updateGate($userEmail, $this->user);

        if ($referer = $request->get('referer')) {
            return redirect($referer)->with('success', $userEmail['name'] . ' successfully updated.');
        } else {
            return redirect()->route('admin.system.user-email.show', $userEmail)
                ->with('success', $userEmail['name'] . ' successfully updated.');
        }
    }

    /**
     * Remove the specified user email from storage.
     *
     * @param UserEmail $userEmail
     * @return RedirectResponse
     */
    public function destroy(UserEmail $userEmail): RedirectResponse
    {
        deleteGate($userEmail, $this->user);

        $userEmail->delete();

        return redirect(referer('admin.system.user-email.index'))
            ->with('success', $userEmail['name'] . ' deleted successfully.');
    }

    /**
     * @return BinaryFileResponse
     */
    public function export(): BinaryFileResponse
    {
        $filename = request()->has('timestamp')
            ? 'user_emails_' . date("Y-m-d-His") . '.xlsx'
            : 'user_emails.xlsx';

        return Excel::download(new UserEmailsExport(), $filename);
    }
}
