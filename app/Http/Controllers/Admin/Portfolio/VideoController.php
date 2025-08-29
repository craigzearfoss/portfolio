<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Http\Controllers\Controller;
use App\Http\Requests\Portfolio\VideoStoreRequest;
use App\Http\Requests\Portfolio\VideoUpdateRequest;
use App\Models\Portfolio\Video;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class VideoController extends Controller
{
    const ROWS_PER_PAGE = 20;

    /**
     * Display a listing of recipe ingredients.
     */
    public function index(): View
    {
        $videos = Video::latest()->paginate(self::ROWS_PER_PAGE);

        return view('admin.portfolio.video.index', compact('videos'))
            ->with('i', (request()->input('page', 1) - 1) * self::ROWS_PER_PAGE);
    }

    /**
     * Show the form for creating a new video.
     */
    public function create(): View
    {
        return view('admin.portfolio.video.create');
    }

    /**
     * Store a newly created video in storage.
     */
    public function store(VideoStoreRequest $request): RedirectResponse
    {
        Video::create($request->validated());

        return redirect()->route('admin.portfolio.video.index')
            ->with('success', 'Video created successfully.');
    }

    /**
     * Display the specified video.
     */
    public function show(Video $video): View
    {
        return view('admin.portfolio.video.show', compact('video'));
    }

    /**
     * Show the form for editing the specified video.
     */
    public function edit(Video $video): View
    {
        return view('admin.portfolio.video.edit', compact('video'));
    }

    /**
     * Update the specified video in storage.
     */
    public function update(VideoUpdateRequest $request, Video $video): RedirectResponse
    {
        $video->update($request->validated());

        return redirect()->route('admin.portfolio.video.index')
            ->with('success', 'Video updated successfully');
    }

    /**
     * Remove the specified video from storage.
     */
    public function destroy(Video $video): RedirectResponse
    {
        $video->delete();

        return redirect()->route('admin.portfolio.video.index')
            ->with('success', 'Video deleted successfully');
    }
}
