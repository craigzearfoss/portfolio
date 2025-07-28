<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\VideoStoreRequest;
use App\Http\Requests\VideoUpdateRequest;
use App\Models\Personal\Video;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class VideoController extends Controller
{
    const NUM_PER_PAGE = 20;

    /**
     * Display a listing of the video.
     */
    public function index(): View
    {
        $videos = Video::latest()->paginate(self::NUM_PER_PAGE);

        return view('admin.video.index', compact('videos'))
            ->with('i', (request()->input('page', 1) - 1) * self::NUM_PER_PAGE);
    }

    /**
     * Show the form for creating a new video.
     */
    public function create(): View
    {
        return view('admin.video.create');
    }

    /**
     * Store a newly created video in storage.
     */
    public function store(VideoStoreRequest $request): RedirectResponse
    {
        Video::create($request->validated());

        return redirect()->route('admin.video.index')
            ->with('success', 'Video created successfully.');
    }

    /**
     * Display the specified video.
     */
    public function show(Video $video): View
    {
        return view('admin.video.show', compact('video'));
    }

    /**
     * Show the form for editing the specified video.
     */
    public function edit(Video $video)
    {
        return view('admin.video.edit', compact('video'));
    }

    /**
     * Update the specified video in storage.
     */
    public function update(VideoUpdateRequest $request, Video $video): RedirectResponse
    {
        $video->update($request->validated());

        return redirect()->route('admin.video.index')
            ->with('success', 'Video updated successfully');
    }

    /**
     * Remove the specified video from storage.
     */
    public function destroy(Video $video): RedirectResponse
    {
        $video->delete();

        return redirect()->route('user.link.index')
            ->with('success', 'Video deleted successfully');
    }
}
