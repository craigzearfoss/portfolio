<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Portfolio\StoreVideosRequest;
use App\Http\Requests\Portfolio\UpdateVideosRequest;
use App\Models\Portfolio\Video;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

/**
 *
 */
class VideoController extends BaseAdminController
{
    /**
     * Display a listing of videos.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $perPage = $request->query('per_page', $this->perPage);

        $videos = Video::orderBy('name', 'asc')->paginate($perPage);

        return view('admin.portfolio.video.index', compact('videos'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new video.
     *
     * @return View
     */
    public function create(): View
    {
        return view('admin.portfolio.video.create');
    }

    /**
     * Store a newly created video in storage.
     *
     * @param StoreVideosRequest $storeVideosRequest
     * @return RedirectResponse
     */
    public function store(StoreVideosRequest $storeVideosRequest): RedirectResponse
    {
        $video = Video::create($storeVideosRequest->validated());

        return redirect(referer('admin.portfolio.video.index'))
            ->with('success', $video->name . ' added successfully.');
    }

    /**
     * Display the specified video.
     *
     * @param Video $video
     * @return View
     */
    public function show(Video $video): View
    {
        return view('admin.portfolio.video.show', compact('video'));
    }

    /**
     * Show the form for editing the specified video.
     *
     * @param Video $video
     * @return View
     */
    public function edit(Video $video): View
    {
        return view('admin.portfolio.video.edit', compact('video'));
    }

    /**
     * Update the specified video in storage.
     *
     * @param UpdateVideosRequest $updateVideosRequest
     * @param Video $video
     * @return RedirectResponse
     */
    public function update(UpdateVideosRequest $updateVideosRequest, Video $video): RedirectResponse
    {
        $video->update($updateVideosRequest->validated());

        return redirect(referer('admin.portfolio.video.index'))
            ->with('success', $video->name . ' updated successfully.');
    }

    /**
     * Remove the specified video from storage.
     *
     * @param Video $video
     * @return RedirectResponse
     */
    public function destroy(Video $video): RedirectResponse
    {
        $video->delete();

        return redirect(referer('admin.portfolio.video.index'))
            ->with('success', $video->name . ' deleted successfully.');
    }
}
