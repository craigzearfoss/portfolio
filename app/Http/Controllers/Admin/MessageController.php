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
     * @param Request $request
     * @return View
     */
    public function create(Request $request): View
    {
        $referer = $request->headers->get('referer');

        return view('admin.message.create', compact('referer'));
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

        $referer = $request->headers->get('referer');

        if (!empty($referer)) {
            return redirect(str_replace(config('app.url'), '', $referer))
                ->with('success', 'Message created successfully.');
        } else {
            return redirect()->route('admin.message.index')
                ->with('success', 'Message created successfully.');
        }
    }

    /**
     * Display the specified message.
     *
     * @param Link $link
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
     * @param Request $request
     * @return View
     */
    public function edit(Message $message): View
    {
        $referer = $request->headers->get('referer');

        return view('admin.message.edit', compact('message', 'referer'));
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

        $referer = $request->input('referer');

        if (!empty($referer)) {
            return redirect(str_replace(config('app.url'), '', $referer))
                ->with('success', 'Message updated successfully.');
        } else {
            return redirect()->route('admin.message.index')
                ->with('success', 'Message updated successfully.');
        }
    }

    /**
     * Remove the specified message from storage.
     *
     * @param Message $message
     * @param Request $request
     * @return RedirectResponse
     */
    public function destroy(Message $message, Request $request): RedirectResponse
    {
        $message->delete();

        $referer = $request->input('referer');

        if (!empty($referer)) {
            return redirect(str_replace(config('app.url'), '', $referer))
                ->with('success', 'Message deleted successfully.');
        } else {
            return redirect()->route('admin.message.index')
                ->with('success', 'Message deleted successfully.');
        }
    }
}
