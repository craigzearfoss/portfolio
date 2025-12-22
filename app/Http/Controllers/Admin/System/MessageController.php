<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\System\StoreMessagesRequest;
use App\Http\Requests\System\UpdateMessagesRequest;
use App\Models\System\Message;
use Illuminate\Auth\Access\Gate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 *
 */
class MessageController extends BaseAdminController
{
    /**
     * Display a listing of messages.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $perPage = $request->query('per_page', $this->perPage);

        $messages = Message::latest()->paginate($perPage);

        return view('admin.system.message.index', compact('messages'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new message.
     *
     * @return View
     */
    public function create(): View
    {
        if (!isRootAdmin()) {
            abort(403, 'Only root admins can access this page.');
        }

        return view('admin.system.message.create');
    }

    /**
     * Store a newly created message in storage.
     *
     * @param StoreMessagesRequest $storeMessagesRequest
     * @return RedirectResponse
     */
    public function store(StoreMessagesRequest $storeMessagesRequest): RedirectResponse
    {
        if (!isRootAdmin()) {
            abort(403, 'Only root admins can create new messages.');
        }

        $message = Message::create($storeMessagesRequest->validated());

        return redirect()->route('admin.system.message.show', $message)
            ->with('success', 'Message successfully added.');
    }

    /**
     * Display the specified message.
     *
     * @param Message $message
     * @return View
     */
    public function show(Message $message): View
    {
        return view('admin.system.message.show', compact('message'));
    }

    /**
     * Show the form for editing the specified message.
     *
     * @param Message $message
     * @return View
     */
    public function edit(Message $message): View
    {
        // any admin can edit a message
        //Gate::authorize('update-resource', $message);

        return view('admin.system.message.edit', compact('message'));
    }

    /**
     * Update the specified message in storage.
     *
     * @param UpdateMessagesRequest $updateMessagesRequest
     * @param Message $message
     * @return RedirectResponse
     */
    public function update(UpdateMessagesRequest $updateMessagesRequest, Message $message): RedirectResponse
    {
        // any admin can update a message
        //Gate::authorize('update-resource', $message);

        $message->update($updateMessagesRequest->validated());

        return redirect()->route('admin.system.message.index')
            ->with('success', 'Message successfully updated.');
    }

    /**
     * Remove the specified message from storage.
     *
     * @param Message $message
     * @return RedirectResponse
     */
    public function destroy(Message $message): RedirectResponse
    {
        Gate::authorize('delete-resource', $message);

        $message->delete();

        return redirect(referer('admin.system.message.index'))
            ->with('success', 'Message deleted successfully.');
    }
}
