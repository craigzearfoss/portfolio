<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\System\StoreMessageRequest;
use App\Http\Requests\System\UpdateMessageRequest;
use App\Models\System\Message;
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
        return view('admin.system.message.create');
    }

    /**
     * Store a newly created message in storage.
     *
     * @param StoreMessageRequest $storeMessageRequest
     * @return RedirectResponse
     */
    public function store(StoreMessageRequest $storeMessageRequest): RedirectResponse
    {
        $message = Message::create($storeMessageRequest->validated());

        return redirect(referer('admin.system.message.index'))
            ->with('success', 'Message added successfully.');
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
        return view('admin.system.message.edit', compact('message'));
    }

    /**
     * Update the specified message in storage.
     *
     * @param UpdateMessageRequest $updateMessageRequest
     * @param Message $message
     * @return RedirectResponse
     */
    public function update(UpdateMessageRequest $updateMessageRequest, Message $message): RedirectResponse
    {
        $message->update($updateMessageRequest->validated());

        return redirect(referer('admin.system.message.index'))
            ->with('success', 'Message updated successfully.');
    }

    /**
     * Remove the specified message from storage.
     *
     * @param Message $message
     * @return RedirectResponse
     */
    public function destroy(Message $message): RedirectResponse
    {
        $message->delete();

        return redirect(referer('admin.system.message.index'))
            ->with('success', 'Message deleted successfully.');
    }
}
