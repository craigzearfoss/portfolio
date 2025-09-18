<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Portfolio\VideoStoreRequest;
use App\Http\Requests\Portfolio\VideoUpdateRequest;
use App\Models\Portfolio\Video;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

/**
 *
 */
class VideoController extends BaseController
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
     * @param Request $request
     * @return View
     */
    public function create(Request $request): View
    {
        $referer = $request->headers->get('referer');

        return view('admin.portfolio.video.create', compact('referer'));
    }

    /**
     * Store a newly created video in storage.
     *
     * @param VideoStoreRequest $request
     * @return RedirectResponse
     */
    public function store(VideoStoreRequest $request): RedirectResponse
    {
        $video = Video::create($request->validated());

        $referer = $request->input('referer');

        if (!empty($referer)) {
            return redirect(str_replace(config('app.url'), '', $referer))
                ->with('success', $video->name . ' created successfully.');
        } else {
            return redirect()->route('admin.portfolio.video.index')
                ->with('success', $video->name . ' created successfully.');
        }
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
     * @param Request $request
     * @return View
     */
    public function edit(Video $video): View
    {
        $referer = $request->headers->get('referer');

        return view('admin.portfolio.video.edit', compact('video', 'referer'));
    }

    /**
     * Update the specified video in storage.
     *
     * @param VideoUpdateRequest $request
     * @param Video $video
     * @return RedirectResponse
     */
    public function update(VideoUpdateRequest $request, Video $video): RedirectResponse
    {
        // Validate the posted data and generated slug.
        $validatedData = $request->validated();
        $request->merge([ 'slug' => Str::slug($validatedData['name']) ]);
        $request->validate(['slug' => [ Rule::unique('portfolio_db.videos', 'slug') ] ]);
        $video->update($request->validated());

        $referer = $request->input('referer');

        if (!empty($referer)) {
            return redirect(str_replace(config('app.url'), '', $referer))
                ->with('success', $video->name . ' updated successfully.');
        } else {
            return redirect()->route('admin.portfolio.video.index')
                ->with('success', $video->name . ' updated successfully.');
        }
    }

    /**
     * Remove the specified video from storage.
     *
     * @param Video $video
     * @param Request $request
     * @return RedirectResponse
     */
    public function destroy(Video $video, Request $request): RedirectResponse
    {
        $video->delete();

        $referer = $request->input('referer');

        if (!empty($referer)) {
            return redirect(str_replace(config('app.url'), '', $referer))
                ->with('success', $video->name . ' deleted successfully.');
        } else {
            return redirect()->route('admin.portfolio.video.index')
                ->with('success', $video->name . ' deleted successfully.');
        }
    }
}
