<?php

namespace App\Http\Controllers\Admin\Root\Portfolio;

use App\Http\Controllers\Admin\Root\BaseAdminRootController;
use App\Http\Requests\Portfolio\StoreVideosRequest;
use App\Http\Requests\Portfolio\UpdateVideosRequest;
use App\Models\Portfolio\Video;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

/**
 *
 */
class VideoController extends BaseAdminRootController
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
     * @param StoreVideosRequest $request
     * @return RedirectResponse
     */
    public function store(StoreVideosRequest $request): RedirectResponse
    {
        $video = Video::create($request->validated());

        return redirect()->route('root.portfolio.video.show', $video)
            ->with('success', $video->name . ' successfully added.');
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
        //Gate::authorize('update-resource', $video);

        return view('admin.portfolio.video.edit', compact('video'));
    }

    /**
     * Update the specified video in storage.
     *
     * @param UpdateVideosRequest $request
     * @param Video $video
     * @return RedirectResponse
     */
    public function update(UpdateVideosRequest $request, Video $video): RedirectResponse
    {
        Gate::authorize('update-resource', $video);

        $video->update($request->validated());

        return redirect()->route('root.portfolio.video.show', $video)
            ->with('success', $video->name . ' successfully updated.');
    }

    /**
     * Remove the specified video from storage.
     *
     * @param Video $video
     * @return RedirectResponse
     */
    public function destroy(Video $video): RedirectResponse
    {
        Gate::authorize('delete-resource', $video);

        $video->delete();

        return redirect(referer('root.portfolio.video.index'))
            ->with('success', $video->name . ' deleted successfully.');
    }
}
