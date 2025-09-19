<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\MessageStoreRequest;
use App\Http\Requests\MessageUpdateRequest;
use App\Models\Message;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 *
 */
class MessageController extends BaseController
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

        return view('admin.message.index', compact('messages'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new message.
     *
     * @return View
     */
    public function create(): View
    {
        return view('admin.message.create');
    }

    /**
     * Store a newly created message in storage.
     *
     * @param MessageStoreRequest $request
     * @return RedirectResponse
     */
    public function store(MessageStoreRequest $request): RedirectResponse
    {
        $message = Message::create($request->validated());

        return redirect(referer('admin.message.index'))
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
        return view('admin.message.show', compact('message'));
    }

    /**
     * Show the form for editing the specified message.
     *
     * @param Message $message
     * @return View
     */
    public function edit(Message $message): View
    {
        return view('admin.message.edit', compact('message'));
    }

    /**
     * Update the specified message in storage.
     *
     * @param MessageUpdateRequest $request
     * @param Message $message
     * @return RedirectResponse
     */
    public function update(MessageUpdateRequest $request, Message $message): RedirectResponse
    {
        $message->update($request->validated());

        return redirect(referer('admin.message.index'))
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

        return redirect(referer('admin.message.index'))
            ->with('success', 'Message deleted successfully.');
    }
}
