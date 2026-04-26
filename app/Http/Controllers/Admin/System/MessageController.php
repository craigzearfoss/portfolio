<?php

namespace App\Http\Controllers\Admin\System;

use App\Exports\System\MessagesExport;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\System\StoreMessagesRequest;
use App\Http\Requests\System\UpdateMessagesRequest;
use App\Models\System\Message;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

/**
 *
 */
class MessageController extends BaseAdminController
{
    /**
     * Display a listing of user messages.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        readGate(Message::class, $this->admin);

        $perPage = $request->query('per_page', $this->perPage());

        $allMessages = new Message()->searchQuery(
            $request->all(),
            request()->input('sort') ?? implode('|', Message::SEARCH_ORDER_BY),
            !$this->isRootAdmin ? $this->admin : null
        )
        ->paginate($perPage)->appends(request()->except('page'));

        $pageTitle = 'Messages';

        return view('admin.system.message.index', compact('allMessages', 'pageTitle'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new message.
     *
     * @return View
     */
    public function create(): View
    {
        createGate(Message::class, $this->user);

        return view('admin.system.message.create');
    }

    /**
     * Store a newly created message in storage.
     *
     * @param StoreMessagesRequest $request
     * @return RedirectResponse
     */
    public function store(StoreMessagesRequest $request): RedirectResponse
    {
        createGate(Message::class, $this->user);

        $message = Message::query()->create($request->validated());

        if ($referer = $request->input('referer')) {
            return redirect($referer)->with('success', $message['name'] . ' successfully added.');
        } else {
            return redirect()->route('admin.system.message.show', $message)
                ->with('success', 'Message successfully added.');
        }
    }

    /**
     * Display the specified message.
     *
     * @param Message $message
     * @return View
     */
    public function show(Message $message): View
    {
        readGate($message, $this->user);

        list($prev, $next) = $message->prevAndNextPages(
            $message['id'],
            'admin.system.message.show',
            $this->owner ?? null,
            [ 'name', 'asc' ]
        );

        return view('admin.system.message.show', compact('message', 'prev', 'next'));
    }

    /**
     * Show the form for editing the specified user message.
     *
     * @param Message $message
     * @return View
     */
    public function edit(Message $message): View
    {
        updateGate($message, $this->user);

        return view('admin.system.message.edit', compact('message'));
    }

    /**
     * Update the specified message in storage.
     *
     * @param UpdateMessagesRequest $request
     * @param Message $message
     * @return RedirectResponse
     */
    public function update(UpdateMessagesRequest $request, Message $message): RedirectResponse
    {
        $message->update($request->validated());

        updateGate($message, $this->user);

        if ($referer = $request->input('referer')) {
            return redirect($referer)->with('success', $message['name'] . ' successfully updated.');
        } else {
            return redirect()->route('admin.system.message.show', $message)
                ->with('success', $message['name'] . ' successfully updated.');
        }
    }

    /**
     * Remove the specified user message from storage.
     *
     * @param Message $message
     * @return RedirectResponse
     */
    public function destroy(Message $message): RedirectResponse
    {
        deleteGate($message, $this->user);

        $message->delete();

        return redirect(referer('admin.system.message.index'))
            ->with('success', $message['name'] . ' deleted successfully.');
    }

    /**
     * Export Microsoft Excel file.
     *
     * @return BinaryFileResponse
     */
    public function export(): BinaryFileResponse
    {
        readGate(Message::class, $this->admin);

        $filename = request()->has('timestamp')
            ? 'messages_' . date("Y-m-d-His") . '.xlsx'
            : 'messages.xlsx';

        return Excel::download(new MessagesExport(), $filename);
    }
}
