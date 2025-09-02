<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MessageStoreRequest;
use App\Http\Requests\MessageUpdateRequest;
use App\Models\Message;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MessageController extends Controller
{
    /**
     * Display a listing of messages.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $perPage= $request->query('per_page', $this->perPage);

        $messages = Message::latest()->paginate($perPage);

        return view('admin.message.index', compact('messages'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new message.
     */
    public function create(): View
    {
        return view('admin.message.create');
    }

    /**
     * Store a newly created message in storage.
     */
    public function store(MessageStoreRequest $request): RedirectResponse
    {
        Message::create($request->validated());

        return redirect()->route('admin.message.index')
            ->with('success', 'Message created successfully.');
    }

    /**
     * Display the specified message.
     */
    public function show(Message $message): View
    {
        return view('admin.message.show', compact('message'));
    }

    /**
     * Show the form for editing the specified message.
     */
    public function edit(Message $message): View
    {
        return view('admin.message.edit', compact('message'));
    }

    /**
     * Update the specified message in storage.
     */
    public function update(MessageUpdateRequest $request, Message $message): RedirectResponse
    {
        $message->update($request->validated());

        return redirect()->route('admin.message.index')
            ->with('success', 'Message updated successfully');
    }

    /**
     * Remove the specified message from storage.
     */
    public function destroy(Message $message): RedirectResponse
    {
        $message->delete();

        return redirect()->route('admin.message.index')
            ->with('success', 'Message deleted successfully');
    }
}
